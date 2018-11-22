<?php

namespace App\Http\Controllers;

use App\Product;
use App\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OhMyBrew\BasicShopifyAPI;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function sync()
    {
        //$this->sync_produto();
        $this->sync_pedido();
        return response()->json(['status' => 'success', 'message' => 'Sincronização realizado com sucesso!']);
    }

    /**
     * verifica se o produto foi lancado no shopify, caso nao é lancado
     */
    private function sync_produto()
    {
        //listar os produtos
        $produtos = $this->get_produtos_erp();
        //verificar se existe em shopify
        if(empty($produtos))
        {
            return false;
        }
        $i=1;
        foreach($produtos as $produto)
        {
            if($i % 2 == 0)
            {
                //regra shopify 2 request por segundo
                sleep(2);
            } 

            $shopify_produtos = $this->get_produto_shopify(strtolower(trim($produto->DESC_PROD_NF)));
            if(empty($shopify_produtos) || is_null($shopify_produtos)) //se nao existir o produto cadastrado lancamos um novo
            {
                $this->lanca_produto_shopify($produto);
            }else
            {
                $this->verifica_mudancas_no_erp($produto, $shopify_produtos);
            }            
            $i++;
        }
    }

    /**
     * verifica se o pedido foi lancado no ERP do cliente, caso nao foi e lancado no ERP
     */
    private function sync_pedido()
    {
        //listar os pedidos
        $this->get_pedidos();
        //verificar se existe em shopify

        //update no shopfy
    }

    private function get_pedidos()
    {
        $shop = Shops::where('shopify_domain', '=', session('shopify_domain'))->first();
        $api = new BasicShopifyAPI();
        $api->setShop($shop->shopify_domain);
        $api->setApiKey(env('SHOPIFY_API_KEY'));
        $api->setApiSecret(env('SHOPIFY_API_SECRET'));
        $api->setAccessToken($shop->shopify_token);
        $request = $api->rest('GET', '/admin/orders.json');
        
        echo '<pre>';
        var_dump($request);
        echo '</pre>';
    }

    private function get_produtos_erp()
    {
        $produtos = $this->query_builder("SELECT * FROM produtos WHERE envia_varejo_internet = 1");
        return $produtos;         
    }

    private function query_builder($sql)
    {
        return DB::connection('sqlsrv')->select($sql);
    }

    private function get_produto_shopify($produto)
    {
        $shop = Shops::where('shopify_domain', '=', session('shopify_domain'))->first();
        $api = new BasicShopifyAPI();
        $api->setShop($shop->shopify_domain);
        $api->setApiKey(env('SHOPIFY_API_KEY'));
        $api->setApiSecret(env('SHOPIFY_API_SECRET'));
        $api->setAccessToken($shop->shopify_token);
        $request = $api->rest('GET', '/admin/products.json?title='.$produto);
        return $request->body->products;
    }

    private function lanca_produto_shopify($produto)
    {   
        $result = $this->findById($produto->PRODUTO);
        $arr_produto_barras = array();
        foreach($result as $p)
        {
            $valor = (!empty($p->PRECO_LIQUIDO1) && !is_null($p->PRECO_LIQUIDO1)) ? $this->money_to_br($p->PRECO_LIQUIDO1) : '0.00'; 
            array_push($arr_produto_barras, array(
                'option1' => trim($p->DESC_COR_PRODUTO), //cor
                'option2' => trim($p->GRADE), //tamanho (P,M,G)
                'price'   => $valor
            ));
        }

        //objeto shopify
        $arr_produto = array(
            'product' => array(
                'title'        => trim(ucfirst(strtolower($produto->DESC_PROD_NF))),
                'vendor'       => trim($produto->GRIFFE),
                'product_type' => trim($produto->SUBGRUPO_PRODUTO),
                'tags'         => trim(strtolower($produto->SUBGRUPO_PRODUTO)),
                'variants'     => $arr_produto_barras
            )
        );
        echo '<br><pre>';
        var_dump($this->send($arr_produto));
        echo '</pre>';       
    }

    private function send($params)
    {
        $shop = Shops::where('shopify_domain', '=', session('shopify_domain'))->first();
        $api = new BasicShopifyAPI();
        $api->setShop($shop->shopify_domain);
        $api->setApiKey(env('SHOPIFY_API_KEY'));
        $api->setApiSecret(env('SHOPIFY_API_SECRET'));
        $api->setAccessToken($shop->shopify_token);
        $request = $api->rest('POST', '/admin/products.json', $params);
        return $request->body->product;
    }

    private function findById($id)
    {
        $sql = "SELECT * FROM produtos LEFT JOIN produtos_barra ON produtos_barra.PRODUTO = produtos.PRODUTO";
        $sql.= " LEFT JOIN produto_cores on produto_cores.COR_PRODUTO = produtos_barra.COR_PRODUTO AND produtos.PRODUTO = produto_cores.PRODUTO";
        $sql.= " LEFT JOIN PRODUTOS_PRECOS on PRODUTOS_PRECOS.PRODUTO = produtos.PRODUTO";
        $sql.= " WHERE produtos.envia_varejo_internet = 1 AND produtos.PRODUTO ='". $id ."'";

        return $this->query_builder($sql);
    }

    private function money_to_br($valor)
    {
        return number_format($valor, 2, ',', '.');
    }

    private function verifica_mudancas_no_erp($produto, $shopify_produtos)
    {
        $erp_produto = new StdClass;

        $erp_produto->title        = $produto->trim(ucfirst(strtolower($produto->DESC_PROD_NF)));
        $erp_produto->vendor       = trim($produto->GRIFFE);
        $erp_produto->product_type = trim($produto->SUBGRUPO_PRODUTO);
        $erp_produto->tags         = trim(strtolower($produto->SUBGRUPO_PRODUTO));

        $s_produtos = new StdClass;

        $s_produtos->title        = $shopify_produtos->trim(ucfirst(strtolower($shopify_produtos->title)));
        $s_produtos->vendor       = trim($shopify_produtos->vendor);
        $s_produtos->product_type = trim($shopify_produtos->product_type);
        $s_produtos->tags         = trim(strtolower($shopify_produtos->tags));

        if($s_produtos != $erp_produto)
        {
            //update no shopify
            echo 'update';
        }
    }
}

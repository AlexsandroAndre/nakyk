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
        $this->sync_produto();
        //$this->sync_pedido();
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
            if(isset($produto->DESC_PRODUTO) && !empty($produto->DESC_PRODUTO))
            {
                if($i % 2 == 0)
                {
                    //regra shopify 2 request por segundo
                    sleep(2);
                }                
                $shopify_produtos = $this->get_produto_shopify(strtolower(trim($produto->DESC_PRODUTO)));
                if(empty($shopify_produtos)) //se nao existir o produto cadastrado lancamos um novo
                {
                   $this->lanca_produto_shopify($produto);
                   return false;
                   die('parou');
                }
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
        //return $request->body->products
        // echo '<pre>';
        //     var_dump($request);
        //     echo '</pre>';
    }

    private function get_produtos_erp()
    {
        $produtos = $this->query_builder("SELECT * FROM produtos WHERE envia_varejo_internet = 1");
        array_push($produtos, array_map(array($this, 'produto_barra'), $produtos));
        return $produtos;         
    }

    private function query_builder($sql)
    {
        return DB::connection('sqlsrv')->select($sql);
    }

    private function produto_barra($p)
    {
        $p->produtos_barra = $this->query_builder("SELECT * FROM produtos_barra WHERE produto =" . $p->PRODUTO);
        array_push($p->produtos_barra, array_map(array($this, 'produto_cores'), $p->produtos_barra));
        return $p;
    }

    private function produto_cores($pc)
    {
        $pc->produto_cores = $this->query_builder("SELECT * FROM produto_cores WHERE cor_produto ='" . $pc->COR_PRODUTO. "'");
        return $pc;
    }

    private function get_produto_shopify($produto)
    {
        ///admin/products.json?title=<searchString>,limit=250,page=1,fields="id,title,etc
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
        $arr_produto = array(
            'product' => array(
                'title'        => $produto->DESC_PRODUTO,
                'vendor'       => $produto->GRIFFE,
                'product_type' => $produto->SUBGRUPO_PRODUTO,
                'tags'         => strtolower($produto->SUBGRUPO_PRODUTO)
            )
        );
        
        echo json_encode($arr_produto);
        //$this->send($arr_produto);       
    }

    private function send($params)
    {
        $shop = Shops::where('shopify_domain', '=', session('shopify_domain'))->first();
        $api = new BasicShopifyAPI();
        $api->setShop($shop->shopify_domain);
        $api->setApiKey(env('SHOPIFY_API_KEY'));
        $api->setApiSecret(env('SHOPIFY_API_SECRET'));
        $api->setAccessToken($shop->shopify_token);
        $request = $api->rest('POST', '/admin/products.json', json_encode($params));
        echo '<pre>';
        var_dump($request->body);
        echo '</pre>';
    }
}

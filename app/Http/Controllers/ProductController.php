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
    }

    /**
     * verifica se o produto foi lancado no shopify, caso nao é lancado
     */
    private function sync_produto()
    {
        //listar os produtos
        $produtos = $this->get_produtos_erp();
        //verificar se existe em shopify
        foreach($produtos as $produto)
        {
            //$shopify_produtos = $this->get_produto_shopify($produto->DESC_PRODUTO);
            echo $produto->DESC_PRODUTO.'<br>';
        }
        
        //update no shopfy
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
}

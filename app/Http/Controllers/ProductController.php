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
        $this->get_produtos_erp();
        $p_barras = DB::connection('sqlsrv')->select("SELECT * FROM produtos_barra"); 
        echo '<pre>';
            var_dump($p_barras);
            echo '</pre>';
        //verificar se existe em shopify

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
        return $produtos = DB::connection('sqlsrv')->select("SELECT * FROM produtos");        
    }
}

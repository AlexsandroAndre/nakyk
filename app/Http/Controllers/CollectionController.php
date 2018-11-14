<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Shops;
use Illuminate\Http\Request;
use OhMyBrew\BasicShopifyAPI;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shops::where('shopify_domain', '=', session('shopify_domain'))->first();
        // $api = new BasicShopifyAPI();
        // $api->setShop(session('shopify_domain'));
        // $api->setApiKey(env('SHOPIFY_API_KEY'));
        // $api->setApiSecret(env('SHOPIFY_API_SECRET'));
        // $valid = $api->verifyRequest($_GET);
        //$request = $api->rest('GET', '/admin/collects.json');
        
        echo '<pre>';
            var_dump($shops);
            echo '</pre>';
        return view('collections.index', array('collections' => ''));
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
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        //
    }
}

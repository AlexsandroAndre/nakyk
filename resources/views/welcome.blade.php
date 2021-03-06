@extends('shopify-app::layouts.default')

@section('content')
    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/3.0.0/polaris.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
        <div class="Polaris-Layout">
            <div class="Polaris-Layout__Section">
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Header">
                        <div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
                            <h4 class="Polaris-Heading">
                                Olá: <a class="Polaris-Link" href="<?php url('/'); ?>" data-polaris-unstyled="true">{{ ShopifyApp::shop()->shopify_domain }}</a>
                            </h4>
                        </div>
                    </div>
                    <div class="Polaris-Card__Section" style="min-height:300px;">
                        <div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
                            <button type="button" class="Polaris-Button Polaris-Button--primary" id="btn_sync_shop_to_db" >
                                <span class="Polaris-Button__Content"><span>Sync</span></span>
                            </button> 
                        </div>                                 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        // ESDK page and bar title
        window.mainPageTitle = 'Welcome Page';
            ShopifyApp.ready(function() {
                ShopifyApp.Bar.initialize({
                    title: 'Welcome'
                })
            });
        

        $(function(){
            $("#btn_sync_shop_to_db").click(function(){
                let postData = {
                    url: '/products',
                    method : 'GET',
                    data : { }
                };
                let response = send(postData);
                if(response.status == 'success')
                {
                    alert(response.message);
                }
            });
        });



        function send(object)
        {
            var result = '';
            if(object.method == null){
                object.null = 'GET';
            }
            $.ajax({
                method: object.method,
                url: object.url,
                data: object.data,
                async : false
            })
            .done(function(success){
                result = success;
            })
            .fail(function(error){
                result = error;
            })
            .always(function() {
                //
            });
            return result;
        }   
    </script>
@endsection
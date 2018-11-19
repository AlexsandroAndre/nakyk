@extends('shopify-app::layouts.default')

@section('content')
    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/3.0.0/polaris.min.css" />
    
    <div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
        <div class="Polaris-Layout">
            <div class="Polaris-Layout__Section">
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Header">
                        <div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
                            Olá: <a class="Polaris-Link" href="<?php url('/'); ?>" data-polaris-unstyled="true">{{ ShopifyApp::shop()->shopify_domain }}</a>
                            <br>
                            <!--<a href="<?php echo url('/collections'); ?>">Coleções</a>-->
                            <button type="button" class="Polaris-Button" id="btn_sync_shop_to_db"><span class="Polaris-Button__Content"><span>Sync</span></span></button>
                        </div>
                    </div>
                    <div class="Polaris-DataTable">
                        <div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
                            
                        </div>                                 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
    </script>
@endsection
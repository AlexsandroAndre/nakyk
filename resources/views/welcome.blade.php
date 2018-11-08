@extends('shopify-app::layouts.default')

@section('content')
oi
    <p>You are: {{ ShopifyApp::shop()->shopify_domain }}</p>
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
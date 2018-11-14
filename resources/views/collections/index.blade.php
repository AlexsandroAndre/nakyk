@extends('shopify-app::layouts.default')

@section('content')
<div>
    <a href="<?php url('/'); ?>">Home</a>
    {{ $collections }}
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        // ESDK page and bar title
        window.mainPageTitle = 'Coleções';
            ShopifyApp.ready(function() {
                ShopifyApp.Bar.initialize({
                    title: 'Coleções'
                })
            });
    </script>
@endsection
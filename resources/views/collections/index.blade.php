@extends('shopify-app::layouts.default')

@section('content')
<link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/3.0.0/polaris.min.css" />
<div>
    <a href="<?php url('/'); ?>">Home</a>    
</div>

<div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
  <div class="Polaris-Layout">
    <div class="Polaris-Layout__Section">
      <div class="Polaris-Card">
        <div class="Polaris-Card__Header">
          <h2 class="Polaris-Heading">Produtos</h2>
        </div>
        <div class="Polaris-Card__Section">
          <p>{{ var_dump($collections) }}</p>
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
        window.mainPageTitle = 'Coleções';
            ShopifyApp.ready(function() {
                ShopifyApp.Bar.initialize({
                    title: 'Coleções'
                })
            });
    </script>
@endsection
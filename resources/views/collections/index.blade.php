@extends('shopify-app::layouts.default')

@section('content')
{{phpinfo()}}
<link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/3.0.0/polaris.min.css" />

<div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
  <div class="Polaris-Layout">
    <div class="Polaris-Layout__Section">
      <div class="Polaris-Card">
        <div class="Polaris-Card__Header">
          <h2 class="Polaris-Heading">Produtos</h2>
            <div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
                <a class="Polaris-Link" href="<?php url('/'); ?>" data-polaris-unstyled="true">Home</a>
            </div>
        </div>
        <div class="Polaris-DataTable">
            <div class="Polaris-DataTable__ScrollContainer">
                <table class="Polaris-DataTable__Table">
                    <thead>
                        <tr>
                            <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--fixed Polaris-DataTable__Cell" scope="col">Produto</th>
                            <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Variantes</th>
                            <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--header Polaris-DataTable__Cell" scope="col">Vendedor</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($collections as $produto)
                        <tr class="Polaris-DataTable__TableRow">
                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell">{{ $produto->title }}</td>
                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--numeric">{{ count($produto->variants) }}</td>
                            <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell">{{ $produto->vendor }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
        window.mainPageTitle = 'Coleções';
            ShopifyApp.ready(function() {
                ShopifyApp.Bar.initialize({
                    title: 'Coleções'
                })
            });
    </script>
@endsection
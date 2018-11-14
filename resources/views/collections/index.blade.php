@extends('shopify-app::layouts.default')

@section('content')
<div>
    <a href="<?php url('/'); ?>">Home</a>    
</div>


<div style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-darker:#006d74; --top-bar-background-lighter:#1d9ba4;">
    <div class="Polaris-Page">
        <div class="Polaris-Page-Header Polaris-Page-Header__Header--hasPagination Polaris-Page-Header__Header--hasBreadcrumbs Polaris-Page-Header__Header--hasRollup Polaris-Page-Header__Header--hasSecondaryActions">
            <div class="Polaris-Page-Header__Navigation">
                <nav role="navigation">
                    <a class="Polaris-Breadcrumbs__Breadcrumb" href="/products" data-polaris-unstyled="true">
                        <span class="Polaris-Breadcrumbs__Icon">
                            <span class="Polaris-Icon">
                                <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
                                    <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path>
                                </svg>
                            </span>
                        </span>
                        <span class="Polaris-Breadcrumbs__Content">Products</span>
                    </a>
                </nav>
                <div class="Polaris-Page-Header__Pagination">
                    <nav class="Polaris-Pagination Polaris-Pagination--plain" aria-label="Pagination">
                        <button type="button" class="Polaris-Pagination__Button" aria-label="Previous">
                            <span class="Polaris-Icon">
                                <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
                                    <path d="M17 9H5.414l3.293-3.293a.999.999 0 1 0-1.414-1.414l-5 5a.999.999 0 0 0 0 1.414l5 5a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L5.414 11H17a1 1 0 1 0 0-2" fill-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                        <button type="button" class="Polaris-Pagination__Button" aria-label="Next">
                            <span class="Polaris-Icon">
                                <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
                                    <path d="M17.707 9.293l-5-5a.999.999 0 1 0-1.414 1.414L14.586 9H3a1 1 0 1 0 0 2h11.586l-3.293 3.293a.999.999 0 1 0 1.414 1.414l5-5a.999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                    </nav>
                </div>
            </div>
            <div class="Polaris-Page-Header__MainContent">
                <div class="Polaris-Page-Header__TitleAndActions">
                    <div class="Polaris-Page-Header__Title"> <div>
                    <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Jar With Lock-Lid</h1>
                </div>
            <div>
        </div>
    </div>
    <div class="Polaris-Page-Header__Actions">
        <div class="Polaris-Page-Header__PrimaryAction">
            <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--disabled" disabled="">
                <span class="Polaris-Button__Content"><span>Save</span></span>
            </button>
        </div>
        <div class="Polaris-Page-Header__SecondaryActions">
            <div class="Polaris-Page-Header__Rollup">
                <div>
                    <button type="button" class="Polaris-Button" tabindex="0" aria-controls="Popover1" aria-owns="Popover1" aria-haspopup="true" aria-expanded="false">
                        <span class="Polaris-Button__Content">
                            <span>Actions</span>
                            <span class="Polaris-Button__Icon">
                                <span class="Polaris-Icon">
                                    <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
                                        <path d="M5 8l5 5 5-5z" fill-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="Polaris-Page-Header__IndividualActions"><button class="Polaris-Header-Action" type="button">Duplicate</button><button class="Polaris-Header-Action" type="button">View on your store</button></div>
        </div>
    </div>
</div>

            <div class="Polaris-Page-Header__PrimaryAction"><button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--disabled" disabled=""><span class="Polaris-Button__Content"><span>Save</span></span></button></div>

            </div>

            </div>

            <div class="Polaris-Page__Content">

            <p>{{ var_dump($collections) }}</p>
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
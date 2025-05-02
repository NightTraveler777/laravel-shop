<!DOCTYPE html>
<html lang="zxx" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Hmart-Smart Product eCommerce html Template">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/front.css') }}">
</head>

<body>
<div class="main-wrapper">
    @include('layouts.header')
    @yield('breadcrumb-area')
    <div class="shop-category-area pt-100px pb-100px">
        <div class="container">
            <div class="row">
                @yield('content')
                <div class="col-lg-4 order-lg-first col-md-12 order-md-last mt-md-50px mt-lm-50px" data-aos="fade-up" data-aos-delay="200">
                    @include('layouts.shop-sidebar')
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
<script src="{{ asset('assets/front/js/front.js') }}"></script>
</body>

</html>

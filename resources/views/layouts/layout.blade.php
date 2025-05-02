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
    <div class="blog-list pb-100px pt-100px main-blog-page single-blog-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 order-lg-last col-md-12 order-md-first">
                    @yield('content')
                </div>
                <div class="col-lg-4 order-lg-first col-md-12 order-md-last mt-md-50px mt-lm-50px" data-aos="fade-up" data-aos-delay="200">
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
<script src="{{ asset('assets/front/js/front.js') }}"></script>
</body>

</html>

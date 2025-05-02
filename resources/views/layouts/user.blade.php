<!DOCTYPE html>
<html lang="zxx" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="robots" content="index, follow"/>
    <meta name="description" content="Hmart-Smart Product eCommerce html Template">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/images/favicon.ico') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/front/css/front.css') }}">
</head>

<body>
<div class="main-wrapper">
    @include('layouts.header')
    @yield('breadcrumb-area')
    <div class="account-dashboard pt-100px pb-100px">
        <div class="container alert-wrap">
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    @include('layouts.tabs')
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
<script src="{{ asset('assets/ckeditor5/build/ckeditor.js') }}"></script>
<script>
    let route = "{{route('upload', ['_token' => csrf_token() ])}}";
</script>
<script src="{{ asset('assets/front/js/front.js') }}"></script>
</body>

</html>

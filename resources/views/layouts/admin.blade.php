<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title')</title>

    @include('partial.backend.topasset')
   	@stack('topasset')


</head>

<body class="sb-nav-fixed">

    @include('partial.backend.navbar');

    <div id="layoutSidenav">


        @include('partial.backend.menu')


        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">



                    @yield('content')




                </div>
            </main>
            @include('partial.backend.footer')
        </div>
    </div>





    @include('partial.backend.footerasset')
    @stack('footerasset')
</body>

</html>

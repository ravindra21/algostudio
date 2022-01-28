<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- include bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/mutator.css">
        @yield('styles')
    </head>
    <body class="">
    <section class="container-fluid">
        <section class="row">
            <section class="col-md-2 pl-0">
                @include('layout.dashboard-sidebar')
            </section>
            <section class="col-md-10 pl-0">
                @yield('content')
            </section>
        </section>
    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.amcharts.com/lib/version/5.1.0/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/version/5.1.0/themes/Animated.js"></script>
    <script src="/api.js"></script>
    <script src="/util.js"></script>
    @yield('scripts')
</body>
</html>
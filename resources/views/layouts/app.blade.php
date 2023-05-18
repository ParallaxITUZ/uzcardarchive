<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kafolat') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Core Ui -->
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="{{ asset('vendors/simplebar/css/simplebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
        <!-- Main styles for this application-->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- We use those styles to show code examples, you should remove them in your application.-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
        <link href="{{ asset('css/examples.css') }}" rel="stylesheet">
        <link href="{{ asset('fa/css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/site.css') }}" rel="stylesheet">
        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            // Shared ID
            gtag('config', 'UA-118965717-3');
            // Bootstrap ID
            gtag('config', 'UA-118965717-5');
        </script>
        <link href="{{ asset('vendors/@coreui/chartjs/css/coreui-chartjs.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
    @include('layouts.sidebar')
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            <div class="min-h-screen bg-gray-100">
                @include('layouts.navigation')

                <!-- Page Content -->
                <main>
                    <div class="body flex-grow-1 px-3">
                        <div class="container-fluid">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- CoreUI and necessary plugins-->
        <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
        <script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>
        <!-- We use those scripts to show code examples, you should remove them in your application.-->
        <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/prism.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/unescaped-markup/prism-unescaped-markup.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/normalize-whitespace/prism-normalize-whitespace.js"></script>
        <!-- Plugins and scripts required by this view-->
        <script src="{{ asset('vendors/chart.js/js/chart.min.js') }}"></script>
        <script src="{{ asset('vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
        <script src="{{ asset('vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('js/site.js') }}"></script>
    </body>
</html>

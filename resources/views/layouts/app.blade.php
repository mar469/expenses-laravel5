<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Marek Malbrandt">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Expenses') }}</title>
        <!-- Styles -->
        <link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sb-admin.min.css') }}" rel="stylesheet">
    </head>
    <body class="fixed-nav" id="page-top">

        @include('layouts.navbars')
        @include('layouts.content')

        <!-- Scroll to Top Button -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>

        <!-- Bootstrap core JavaScript -->
        <script src="/vendor/jquery/jquery.min.js"></script>
        <script src="/vendor/popper/popper.min.js"></script>
        <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Plugin JavaScript -->
        <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
        {{--<script src="/vendor/chart.js/Chart.min.js"></script>--}}
        {{--<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>--}}
        {{--<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>--}}
        <script src="/vendor/datatables/jquery.dataTables.js"></script>
        <script src="/vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for this template -->
        <script src="js/sb-admin.min.js"></script>
        <!-- Scripts -->
        @yield('scripts')
    </body>
</html>
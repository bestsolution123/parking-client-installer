<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{ url('/') }}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') </title>
    <meta name="description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
    <meta name="keywords"
        content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="stylesheet" href="/assets/css/jquery.dataTables.min.css" />

    {{-- font awesome --}}
    {{-- <script src="/assets/js/font_awesome.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="/assets/fontawesome-free-6.4.2-web/css/all.css">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/assets/dist/css/bootstrap-select.css">


    <!-- Include Styles -->
    @include('layouts/sections/styles')

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('layouts/sections/scriptsIncludes')


    {{-- date timePicker --}}
    <link rel="stylesheet" href="/assets/css/dateTimePicker/jquery.datetimepicker.min.css" />

    {{-- jquery --}}
    <link rel="stylesheet" href="/assets/css/dateTimePicker/jquery-ui.theme.css" />

    <script src="/assets/js/dateTimePicker/jquery.js"></script>
    <script src="/assets/js/dateTimePicker/jquery-ui.js"></script>
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    {{-- sweetalert --}}
    <script src="/assets/js/sweetalert"></script>


    <style>
        .card {
            min-height: 16em;
        }
    </style>
</head>

<body>
    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->

    {{-- remove while creating package --}}
    {{-- <div class="buy-now">
    <a href="{{config('variables.productPage')}}" target="_blank" class="btn btn-danger btn-buy-now">Upgrade To Pro</a>
  </div> --}}
    {{-- remove while creating package end --}}

    <!-- Include Scripts -->
    @include('layouts/sections/scripts')


    <script src="/assets/js/jquery.dataTables.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/dist/js/bootstrap-select.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                autoFill: true
            });
            $('#myTable_2').DataTable({
                autoFill: true
            });
            $('#myTable_3').DataTable({
                autoFill: true
            });
            $('#myTable_4').DataTable({
                autoFill: true
            });
        });
    </script>

    <script>
        /* Tanpa Rupiah */
        // var tanpa_rupiah = document.getElementById('tanpa-rupiah');
        // tanpa_rupiah.addEventListener('keyup', function(e) {
        //     tanpa_rupiah.value = formatRupiah(this.value);
        // });

        /* Dengan Rupiah */
        var dengan_rupiah = document.getElementById('dengan-rupiah');
        if (dengan_rupiah) {
            dengan_rupiah.addEventListener('keyup', function(e) {
                dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
            });
        }


        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>

    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>

    {{-- date time picker --}}
    <script src="/assets/js/dateTimePicker/jquery.datetimepicker.full.js"></script>

    <script>
        /* Tanpa Rupiah */
        // var tanpa_rupiah = document.getElementById('tanpa-rupiah');
        // tanpa_rupiah.addEventListener('keyup', function(e) {
        //     tanpa_rupiah.value = formatRupiah(this.value);
        // });

        /* Dengan Rupiah */
        var dengan_rupiah = document.getElementById('dengan-rupiah');
        if (dengan_rupiah) {
            dengan_rupiah.addEventListener('keyup', function(e) {
                dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
            });
        }

        var dengan_rupiah_2 = document.getElementById('dengan-rupiah-2');
        if (dengan_rupiah_2) {
            dengan_rupiah_2.addEventListener('keyup', function(e) {
                dengan_rupiah_2.value = formatRupiah(this.value, 'Rp. ');
            });
        }

        var dengan_rupiah_3 = document.getElementById('dengan-rupiah-3');
        if (dengan_rupiah_3) {
            dengan_rupiah_3.addEventListener('keyup', function(e) {
                dengan_rupiah_3.value = formatRupiah(this.value, 'Rp. ');
            });
        }

        var dengan_rupiah_4 = document.getElementById('dengan-rupiah-4');
        if (dengan_rupiah_4) {
            dengan_rupiah_4.addEventListener('keyup', function(e) {
                dengan_rupiah_4.value = formatRupiah(this.value, 'Rp. ');
            });
        }

        var dengan_rupiah_5 = document.getElementById('dengan-rupiah-5');
        if (dengan_rupiah_5) {
            dengan_rupiah_5.addEventListener('keyup', function(e) {
                dengan_rupiah_5.value = formatRupiah(this.value, 'Rp. ');
            });
        }


        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>


</body>

</html>

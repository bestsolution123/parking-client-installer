@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan Pendapatan Member</span></h4>

    <div class="row my-3">
        <div class="col-lg-6 col-md-6 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                            </div>
                            <span class="fw-semibold d-block mb-1"> PENDAPATAN HARI INI</span>
                            <h3 class="card-title mb-2">{{ $all_price_today }}</h3>
                            <br>
                            <span class="fw-semibold d-block mb-1"> QTY KENDARAAN HARI INI
                            </span>
                            <h3 class="card-title mb-2">{{ count($transaction_all_vehicle_today) }}</h3>
                            <br>
                            <ul class="p-0 m-0">

                                @foreach ($vehicle_today as $item)
                                    @if (count($item->transaction) > 0)
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="fa-solid  fa-square-parking"></i></span>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0 fs-5">{{ $item->name }}</h6>
                                                    {{-- <span class="text-muted">Mobile, Earbuds, TV</span> --}}
                                                </div>
                                                <div class="user-progress">
                                                    <span class="fw-semibold fs-4 "
                                                        id="pegawai_laki_laki">{{ $count_vehicle_today[$item->name] }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                            </div>
                            <span class="fw-semibold d-block mb-1"> PENDAPATAN MINGGU INI
                            </span>
                            <h3 class="card-title text-nowrap mb-1">{{ $all_price_weekly }}</h3>
                            <br>
                            <span class="fw-semibold d-block mb-1"> QTY KENDARAAN MINGGU INI
                            </span>
                            <h3 class="card-title text-nowrap mb-1">{{ count($transaction_all_vehicle_weekly) }}</h3>
                            <br>
                            <ul class="p-0 m-0">

                                @foreach ($vehicle_weekly as $item)
                                    @if (count($item->transaction) > 0)
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="fa-solid  fa-square-parking"></i></span>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0 fs-5">{{ $item->name }}</h6>
                                                    {{-- <span class="text-muted">Mobile, Earbuds, TV</span> --}}
                                                </div>
                                                <div class="user-progress">
                                                    <span class="fw-semibold fs-4 "
                                                        id="pegawai_laki_laki">{{ $count_vehicle_weekly[$item->name] }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                            </div>
                            <span class="fw-semibold d-block mb-1"> PENDAPATAN BULAN INI
                            </span>
                            <h3 class="card-title mb-2">{{ $all_price_monthly }}</h3>
                            <br>
                            <span class="fw-semibold d-block mb-1"> QTY KENDARAAN BULAN INI

                            </span>
                            <h3 class="card-title mb-2">{{ count($transaction_all_vehicle_monthly) }}</h3>
                            <br>
                            <ul class="p-0 m-0">

                                @foreach ($vehicle_monthly as $item)
                                    @if (count($item->transaction) > 0)
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="fa-solid  fa-square-parking"></i></span>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0 fs-5">{{ $item->name }}</h6>
                                                    {{-- <span class="text-muted">Mobile, Earbuds, TV</span> --}}
                                                </div>
                                                <div class="user-progress">
                                                    <span class="fw-semibold fs-4 "
                                                        id="pegawai_laki_laki">{{ $count_vehicle_monthly[$item->name] }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                            </div>
                            <span class="fw-semibold d-block mb-1"> PENDAPATAN TAHUN INI</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $all_price_yearly }}</h3>
                            <br>
                            <span class="fw-semibold d-block mb-1"> QTY KENDARAAN TAHUN INI</span>
                            <h3 class="card-title text-nowrap mb-1">{{ count($transaction_all_vehicle_yearly) }}</h3>
                            <br>
                            <ul class="p-0 m-0">

                                @foreach ($vehicle_yearly as $item)
                                    @if (count($item->transaction) > 0)
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="fa-solid  fa-square-parking"></i></span>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0 fs-5">{{ $item->name }}</h6>
                                                    {{-- <span class="text-muted">Mobile, Earbuds, TV</span> --}}
                                                </div>
                                                <div class="user-progress">
                                                    <span class="fw-semibold fs-4 "
                                                        id="pegawai_laki_laki">{{ $count_vehicle_yearly[$item->name] }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>

    <script>
        function finishTransaction(id, name) {

            var result = confirm('Kamu Yakin Ingin Menyelesaikan Transaksi?');

            if (result == true) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"),
                    },
                    type: "POST",
                    url: "/dashboard/transaction/finish/" + id,
                    data: {
                        status: name,
                    },
                    dataType: "json",
                    success: function(response) {

                        // console.log(response);
                        // if (response.status == 400) {

                        // } else {

                        // }

                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: "/gate/printParkingExit/" + response.id,
                            success: function(response) {
                                console.log(response);
                                location.reload();
                            },
                        });
                    },
                });
            } else {
                doc = "Cancel was pressed.";
            }




        }
    </script>

    <script>
        $(document).ready(function() {

            // time 
            $(".date_custom").datetimepicker({
                format: "Y-m-d",
                formatDate: "Y-m-d",
                step: 1,
                timepicker: false,
            });

        });
    </script>



@endsection

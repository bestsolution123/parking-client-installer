@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan</span></h4>

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-3">
        <div class="row d-flex justify-content-end text-end">
            <span>
                <form action="/dashboard/report">
                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <div class="input-group date">
                            <input class="form-control select-time-schedule date_custom" name="calendar" value=""
                                readonly="readonly" />
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <select class="form-control selectpicker d-block border" name="gate" id="mode_type"
                            data-live-search="true">
                            <option value="" selected>Pilih Gate Parkir</option>
                            <?php
                                        for($i = 0; $i < count($site_gate_parking); $i++){
                                           
                                        ?>
                            <option value="{{ $site_gate_parking[$i]->name }}">
                                {{ $site_gate_parking[$i]->name }}
                            </option>
                            <?php
                                    }
                                        ?>
                        </select>
                    </div>

                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Filter Data</button>
                    </div>
                    <a href="{{ route('dashboard/report') }}">
                        <button type="button" class="btn btn-primary">Reset</button>
                    </a>
                </form>
            </span>
        </div>
    </div>

    <!-- report transaction -->
    {{-- <div class="my-3">
        <div class="row d-flex justify-content-end text-start">
            <span class="fs-3 fw-bold">Laporan Transaksi</span>
        </div>

    </div> --}}

    {{-- 
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Laporan Transaction</h5>
                </div>
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pintu Masuk</th>
                                <th>Pintu Keluar</th>
                                <th>Jenis Kendaraan</th>
                                <th>No Polisi</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->site_gate_parking->name }}</td>
                                    <td>{{ $item->gate_out }}</td>
                                    <td>{{ $item->site_gate_parking->vehicle->name }}</td>
                                    <td>{{ $item->plat_number }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->date_in }}</td>
                                    <td>{{ $item->date_out }}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Transaksi</h5>
                </div>
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pintu Masuk</th>
                                <th>Pintu Keluar</th>
                                <th>Jenis Kendaraan</th>
                                <th>No Polisi</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->site_gate_parking->name }}</td>
                                    <td>{{ $item->gate_out }}</td>
                                    <td>{{ $item->site_gate_parking->vehicle->name }}</td>
                                    <td>{{ $item->plat_number }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->date_in }}</td>
                                    <td>{{ $item->date_out }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                {{-- <a href="/dashboard/printer/edit/{{ encrypt($item->id) }}"
                                                        href="javascript:void(0);">
                                                        <button type="button" class="btn btn-success">
                                                            <i class="bx bx-edit-alt me-2"></i>
                                                        </button>
                                                    </a> --}}
                                                @if ($item->status == '-' || $item->status == 'Belum Membayar')
                                                    <div class="dropdown">

                                                        <a class=" deleteData " href="javascript:void(0);"
                                                            attr-id="{{ encrypt($item->id) }}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="bx bx-check me-2"></i>

                                                        </a>

                                                        <ul class="dropdown-menu">
                                                            @foreach ($punishment as $item2)
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        onclick="return finishTransaction('{{ encrypt($item->id) }}','{{ $item2->name }}')">
                                                                        <button type="button" class="btn">
                                                                            {{ $item2->name }}
                                                                        </button>
                                                                    </a>
                                                                </li>
                                                            @endforeach

                                                            <li>
                                                                <a class="dropdown-item"
                                                                    onclick="return finishTransaction('{{ encrypt($item->id) }}','Selesai')">
                                                                    <button type="button" class="btn">
                                                                        Selesai
                                                                    </button>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- counting semua kendaraan  -->
    <div class="my-3">
        <div class="row d-flex justify-content-end text-start">
            <span class="fs-3 fw-bold">Laporan Kendaraan</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2"></h2>
                            <span class="fs-5">Total Kendaraan</span>
                        </div>
                        {{-- <div id="orderStatisticsChart"></div> --}}
                        {{-- <div>
                            <canvas id="chart_gender" style=" height:15vh; width:15vw"></canvas>
                        </div> --}}
                        <div class="user-progress">
                            <span class="fw-semibold fs-4 "
                                id="pegawai_laki_laki">{{ count($transaction_all_vehicle) }}</span>
                        </div>
                    </div>
                    <ul class="p-0 m-0">
                        @foreach ($transaction_all_vehicle_unique as $item)
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="fa-solid  fa-square-parking"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0 fs-5">{{ $item->name }}</h6>
                                        {{-- <span class="text-muted">Mobile, Earbuds, TV</span> --}}
                                    </div>
                                    <div class="user-progress">
                                        <span class="fw-semibold fs-4 " id="pegawai_laki_laki">{{ $item->count }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <!--/ Total Revenue -->
    </div>

    <!-- laporan tipe kendaraan  -->
    <div class="my-3">
        <div class="row d-flex justify-content-end text-start">
            <span class="fs-3 fw-bold">Laporan Tipe Kendaraan</span>
        </div>

        <div class="row d-flex justify-content-end text-end">
            <span>
                <div class="btn-group">
                    <a href="/dashboard/exportExcel">
                        <button type="button" class="btn btn-success"> <i class="fa-solid fa-file-excel"></i> Export
                            Excel
                        </button>
                    </a>

                </div>
            </span>
        </div>


    </div>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Laporan</h5>
                </div>
                <div class="card-body">
                    <table id="myTable_2" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Polisi</th>
                                <th>Jenis Kendaraan</th>
                                <th>Duration</th>
                                <th>Biaya</th>
                                <th>Status</th>
                                <th>Pintu Masuk</th>
                                <th>Pintu Keluar</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Metode Pembayaran</th>
                                <th>Foto Masuk</th>
                                <th>Foto Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($transaction as $item)
                                @php
                                    //calculate time
                                    $date1 = new DateTime($item->date_in);
                                    $date2 = new DateTime($item->date_out);
                                    $interval = $date1->diff($date2);
                                @endphp

                                @if ($interval->d < 1)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->plat_number }}</td>
                                        <td>{{ $item->site_gate_parking->vehicle->name }}</td>
                                        <td>
                                            @php

                                                if ($interval->d != 0) {
                                                    echo $interval->d . ' Hari ' . $interval->h . ' Jam ';
                                                } else {
                                                    echo $interval->h . ' Jam ';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                $price = 0;
                                                $time_1 = 0;
                                                $time_2 = 0;

                                                if ($interval->h < 1 && $interval->i < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                                                    $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                                                    $price = $grace_time;
                                                } elseif ($interval->h < 1 && $interval->i > (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                                                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                                                    $price = $time_price_1;
                                                }

                                                if ($time_1 == 0) {
                                                    if ($interval->d < 1 && $interval->h > 0) {
                                                        $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                                                        $price = $price + $time_price_1;
                                                    }
                                                    $time_1++;
                                                }

                                                if ($time_2 == 0) {
                                                    if ($interval->d < 1 && $interval->h > 1) {
                                                        $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                                                        $price = $price + $time_price_2;
                                                    }
                                                    $time_2++;
                                                }

                                                if ($interval->d < 1 && $interval->h > 2) {
                                                    $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                                                    $price = $price + $time_price_3 * ($interval->h - 2);
                                                }

                                                if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                                                    $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                                                    if ($price > $maximum_daily_price) {
                                                        $price = $maximum_daily_price;
                                                    }
                                                }

                                                foreach ($punishment as $item2) {
                                                    if ($item2->name == $item->status) {
                                                        $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                                                        $price = $price + $punishment_price;
                                                    }
                                                }

                                                $price = 'Rp ' . number_format($price);

                                                echo $price;

                                            @endphp
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->site_gate_parking->name }}</td>
                                        <td>{{ $item->gate_out }}</td>
                                        <td>{{ $item->date_in }}</td>
                                        <td>{{ $item->date_out }}</td>
                                        <td>Metode Pembayaran</td>
                                        <td>
                                            <a href="{{ asset('storage/cctv/' . $item->in_photo) }}">
                                                <img src="{{ asset('storage/cctv/' . $item->in_photo) }}"
                                                    class="img-thumbnail" alt="...">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/cctv/' . $item->out_photo) }}">
                                                <img src="{{ asset('storage/cctv/' . $item->out_photo) }}"
                                                    class="img-thumbnail" alt="...">
                                            </a>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- laporan tipe kendaraan menginap -->
    <div class="my-3">
        <div class="row d-flex justify-content-end text-start">
            <span class="fs-3 fw-bold">Laporan Tipe Kendaraan Menginap</span>
        </div>

        <div class="row d-flex justify-content-end text-end">
            <span>
                <div class="btn-group">
                    <button type="button" class="btn btn-success"> <i class="fa-solid fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </span>
        </div>

    </div>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Laporan</h5>
                </div>
                <div class="card-body">
                    <table id="myTable_3" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Polisi</th>
                                <th>Jenis Kendaraan</th>
                                <th>Duration</th>
                                <th>Biaya</th>
                                <th>Status</th>
                                <th>Pintu Masuk</th>
                                <th>Pintu Keluar</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Metode Pembayaran</th>
                                <th>Foto Masuk</th>
                                <th>Foto Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($transaction as $item)
                                @php
                                    //calculate time
                                    $date1 = new DateTime($item->date_in);
                                    $date2 = new DateTime($item->date_out);
                                    $interval = $date1->diff($date2);
                                @endphp

                                @if ($interval->d > 0)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->plat_number }}</td>
                                        <td>{{ $item->site_gate_parking->vehicle->name }}</td>
                                        <td>
                                            @php

                                                if ($interval->d != 0) {
                                                    echo $interval->d . ' Hari ' . $interval->h . ' Jam ';
                                                } else {
                                                    echo $interval->h . ' Jam ';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                $price = 0;
                                                $time_1 = 0;
                                                $time_2 = 0;

                                                if ($interval->h < 1 && $interval->m < (int) $item->site_gate_parking->vehicle->grace_time_duration) {
                                                    $grace_time = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->grace_time);
                                                    $price = $grace_time;
                                                }

                                                if ($time_1 == 0) {
                                                    if ($interval->d > 0 && $interval->h > 0) {
                                                        $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_1);
                                                        $price = $price + $time_price_1;
                                                    }
                                                    $time_1++;
                                                }

                                                if ($time_2 == 0) {
                                                    if ($interval->d > 0 && $interval->h > 1) {
                                                        $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_2);
                                                        $price = $price + $time_price_2;
                                                    }
                                                    $time_2++;
                                                }

                                                if ($interval->d > 0 && $interval->h > 2) {
                                                    $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->time_price_3);
                                                    $price = $price + $time_price_3 * ($interval->h - 2);
                                                }

                                                if ($item->site_gate_parking->vehicle->maximum_daily == 1) {
                                                    $maximum_daily_price = (int) str_replace(['.', 'Rp'], '', $item->site_gate_parking->vehicle->maximum_daily_price);
                                                    $price = $price + $maximum_daily_price * $interval->d;
                                                }

                                                foreach ($punishment as $item2) {
                                                    if ($item2->name == $item->status) {
                                                        $punishment_price = (int) str_replace(['.', 'Rp'], '', $item2->price);
                                                        $price = $price + $punishment_price;
                                                    }
                                                }

                                                $price = 'Rp ' . number_format($price);

                                                echo $price;

                                            @endphp
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->site_gate_parking->name }}</td>
                                        <td>{{ $item->gate_out }}</td>
                                        <td>{{ $item->date_in }}</td>
                                        <td>{{ $item->date_out }}</td>
                                        <td>
                                            <a href="{{ asset('storage/cctv/' . $item->in_photo) }}">
                                                <img src="{{ asset('storage/cctv/' . $item->in_photo) }}"
                                                    class="img-thumbnail" alt="...">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/cctv/' . $item->out_photo) }}">
                                                <img src="{{ asset('storage/cctv/' . $item->out_photo) }}"
                                                    class="img-thumbnail" alt="...">
                                            </a>
                                        </td>
                                        <td>{{ $item->date_in }}</td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
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

            var d = new Date();
            if (d.getMonth() + 1 < 10) {
                var strDate = d.getFullYear() + "-0" + (d.getMonth() + 1) + "-" + d.getDate();
            } else {
                var strDate = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
            }

            $(".date_custom").val(strDate);

        });
    </script>



@endsection

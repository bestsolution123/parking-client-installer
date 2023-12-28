@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan Pembatalan Transaksi</span></h4>

    <div class="my-3">
        <div class="row d-flex justify-content-end text-end">
            <span>
                <form action="/dashboard/report/pembatalan/transaksi">
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
                    <a href="{{ route('dashboard/report/pembatalan/transaksi') }}">
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

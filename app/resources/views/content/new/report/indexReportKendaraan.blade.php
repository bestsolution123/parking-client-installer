@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan Kendaraan</span></h4>

    <div class="my-3">
        <div class="row d-flex justify-content-end text-end">
            <span>
                <form action="/dashboard/report/kendaraan">
                    <div class="row">

                        <div class="col-12 mb-4">
                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <div class="input-group date">
                                    <input class="form-control select-time-schedule date_custom" name="calendar_from"
                                        readonly="readonly"
                                        value="{{ request('calendar_from') == '' ? '' : request('calendar_from') }}" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            Tanggal Awal
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <div class="input-group date">
                                    <input class="form-control select-time-schedule date_custom" name="calendar_to"
                                        value="{{ request('calendar_to') == '' ? '' : request('calendar_to') }}"
                                        readonly="readonly" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            Tanggal Akhir
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <select class="form-control selectpicker d-block border" name="gate" id="mode_type"
                                    data-live-search="true">
                                    <option value="" selected>Pilih Gate Parkir</option>
                                    @foreach ($site_gate_parking as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == request('gate') ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <select class="form-control selectpicker d-block border" name="vehicle" id="mode_type"
                                    data-live-search="true">
                                    <option value="" selected>Pilih Jenis Kendaraan</option>
                                    @foreach ($vehicle as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == request('vehicle') ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <select class="form-control selectpicker d-block border" name="operator" id="mode_type"
                                    data-live-search="true">
                                    <option value="" selected>Pilih Operator</option>
                                    @foreach ($User as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == request('operator') ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <select class="form-control selectpicker d-block border" name="no_polisi" id="mode_type"
                                    data-live-search="true">
                                    <option value="" selected>Pilih Nomor Polisi</option>
                                    @foreach ($transaction_no_pol as $item)
                                        <option value="{{ $item->plat_number }}"
                                            {{ $item->plat_number == request('no_polisi') ? 'selected' : '' }}>
                                            {{ $item->plat_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <select class="form-control selectpicker d-block border" name="visitor_type" id="mode_type"
                                    data-live-search="true">
                                    <option value="" selected>Pilih Jenis Visitor</option>
                                    @php
                                        $visitor_type = ['Regular', 'Member', 'Voucher'];
                                    @endphp
                                    @foreach ($visitor_type as $item)
                                        <option value="{{ $item }}"
                                            {{ $item == request('visitor_type') ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="col-12">
                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">Filter Data</button>
                            </div>
                            <a href="{{ route('dashboard/report/kendaraan') }}">
                                <button type="button" class="btn btn-primary">Reset</button>
                            </a>
                        </div>
                    </div>
                </form>
            </span>
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
                                id="pegawai_laki_laki">{{ $count_transaction_overnight }}</span>
                        </div>
                    </div>
                    <ul class="p-0 m-0">

                        @foreach ($vehicle as $item)
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
                                        <span class="fw-semibold fs-4 "
                                            id="pegawai_laki_laki">{{ $count_vehicle_overnight[$item->name] }}</span>
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
                                        <td>{{ $item->vehicle->name }}</td>
                                        <td>
                                            @php

                                                if ($interval->d != 0) {
                                                    echo $interval->d . ' Hari ' . $interval->h . ' Jam ' . $interval->i . ' Menit ';
                                                } else {
                                                    echo $interval->h . ' Jam ' . $interval->i . ' Menit ';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                $price = 0;
                                                $time_1 = 0;
                                                $time_2 = 0;

                                                if ($interval->d < 1 && $interval->h < 1 && $interval->i < (int) $item->vehicle->grace_time_duration) {
                                                    $grace_time = (int) str_replace(['.', 'Rp'], '', $item->vehicle->grace_time);
                                                    $price = $grace_time;
                                                } elseif ($interval->d < 1 && $interval->h < 1 && $interval->i > (int) $item->vehicle->grace_time_duration) {
                                                    $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                                                    $price = $time_price_1;
                                                }

                                                if ($time_1 == 0) {
                                                    if (60 + $interval->i >= $item->vehicle->limitation_time_duration) {
                                                        $time_price_1 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_1);
                                                        $price = $price + $time_price_1;
                                                    }
                                                    $time_1++;
                                                }

                                                if ($time_2 == 0) {
                                                    if ($interval->h * 60 + $interval->i >= 60 + $item->vehicle->limitation_time_duration) {
                                                        $time_price_2 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_2);
                                                        $price = $price + $time_price_2;
                                                    }
                                                    $time_2++;
                                                }

                                                if ($interval->h * 60 + $interval->i >= 120 + $item->vehicle->limitation_time_duration) {
                                                    $time_price_3 = (int) str_replace(['.', 'Rp'], '', $item->vehicle->time_price_3);
                                                    if ($interval->h <= 2) {
                                                        $price = $price + $time_price_3;
                                                    } else {
                                                        $price = $price + $time_price_3 * ($interval->h - 1);
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
                                        <td>
                                            @if ($item->status == '-')
                                                -
                                            @else
                                                {{ $item->date_out }}
                                            @endif

                                        </td>
                                        <td>{{ $item->payment_method }}</td>
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

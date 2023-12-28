@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Transaksi Member</span></h4>

    <div class="my-3">
        <div class="row d-flex justify-content-end text-end">
            <span>
                <form action="/dashboard/transaction/member">
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
                            <div class="btn-group">
                                <a href="/dashboard/exportExcel/transaksi/Member">
                                    <button type="button" class="btn btn-success"> <i class="fa-solid fa-file-excel"></i>
                                        Export
                                        Excel
                                    </button>
                                </a>

                            </div>
                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">Filter Data</button>
                            </div>
                            <a href="{{ route('dashboard/transaction/member') }}">
                                <button type="button" class="btn btn-primary">Reset</button>
                            </a>
                        </div>
                    </div>
                </form>
            </span>
        </div>
    </div>

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
                                <th>Zona Waktu</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($transaction as $item)
                                @php
                                    //calculate time
                                    $date1 = new DateTime($item->date_in);
                                    $date2 = new DateTime($item->date_out);
                                    $interval = $date1->diff($date2);
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->site_gate_parking->name }}</td>
                                    <td>{{ $item->gate_out }}</td>
                                    <td>{{ $item->vehicle->name }}</td>
                                    <td>{{ $item->plat_number }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->timeZone }}</td>
                                    <td>{{ $item->date_in }}</td>
                                    <td>
                                        @if ($item->status == '-')
                                            -
                                        @else
                                            {{ $item->date_out }}
                                        @endif

                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-3">
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
                                            <div class="col-3">
                                                <div class="dropdown">

                                                    <a class=" deleteData " href="javascript:void(0);"
                                                        attr-id="{{ encrypt($item->id) }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-print"></i>
                                                    </a>

                                                    <ul class="dropdown-menu">
                                                        @foreach ($printer as $item3)
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    onclick="return printTransaction('{{ encrypt($item->id) }}','{{ encrypt($item3->id) }}')">
                                                                    <button type="button" class="btn">
                                                                        {{ $item3->name }}
                                                                    </button>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
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

                        location.reload();

                        // $.ajax({
                        //     type: "GET",
                        //     dataType: "json",
                        //     url: "/gate/printParkingExit/" + response.id,
                        //     success: function(response) {
                        //         console.log(response);
                        //         location.reload();
                        //     },
                        // });
                    },
                });
            } else {
                doc = "Cancel was pressed.";
            }




        }

        function printTransaction(id, id_printer) {

            var result = confirm('Kamu Yakin Ingin Mencetak Transaksi?');

            if (result == true) {
                $.ajax({
                    type: "GET",
                    url: "/gate/printParkingExit/" + id + "/" + id_printer,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        // if (response.status == 400) {

                        // } else {

                        // }

                        // $.ajax({
                        //     type: "GET",
                        //     dataType: "json",
                        //     url: "/gate/printParkingExit/" + response.id,
                        //     success: function(response) {
                        //         console.log(response);
                        //         location.reload();
                        //     },
                        // });
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

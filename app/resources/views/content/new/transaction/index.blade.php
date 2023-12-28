@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Transaksi</span></h4>

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
                                <th>Plat Number</th>
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
                                    <td>{{ $item->created_at }}</td>
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

@endsection

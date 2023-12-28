@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kendaraan</span></h4>

    <div class="my-3">
        <div class="row d-flex justify-content-end text-end">
            <span>
                <a href="/dashboard/vehicle/create">
                    <button type="button" class="btn btn-primary">+ Tambah Data</button>
                </a>
            </span>
        </div>
    </div>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Kendaraan</h5>
                </div>
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Kendaraan</th>
                                <th>Tipe Kendaraan</th>
                                <th>Harga Jam Ke 1</th>
                                <th>Harga Jam Ke 2</th>
                                <th>Harga Jam Ke 3</th>
                                <th>Batas Maksimal Harga Per / Hari</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicle as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->vehicle_initial->name }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->time_price_1 }}</td>
                                    <td>{{ $item->time_price_2 }}</td>
                                    <td>{{ $item->time_price_3 }}</td>
                                    <td>{{ $item->maximum_daily_price }}</td>
                                    <td>

                                        <div class="row">
                                            <div class="col">

                                                <a href="/dashboard/vehicle/edit/{{ encrypt($item->id) }}"
                                                    href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-2"></i>

                                                </a>

                                                <a class=" deleteData" href="javascript:void(0);"
                                                    attr-id="{{ encrypt($item->id) }}">
                                                    <i class="bx bx-trash me-2"></i>

                                                </a>

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
        $(".deleteData").click(function() {
            $button_deleteData = $(this).closest("tr");


            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "Anda tidak akan dapat mengembalikannya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {

                    //delete action
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"),
                        },
                        type: "POST",
                        url: "/dashboard/vehicle/delete/" + $(".deleteData")
                            .attr("attr-id"),
                        // data: data,
                        dataType: "json",
                        success: function(response) {
                            $button_deleteData.remove();
                            // console.log(response);
                            // if (response.status == 400) {

                            // } else {

                            // }
                        },
                    });

                    //delete alert
                    Swal.fire(
                        'Dihapus!',
                        'File berhasil dihapus.',
                        'success'
                    )
                }
            })


        });
    </script>

@endsection

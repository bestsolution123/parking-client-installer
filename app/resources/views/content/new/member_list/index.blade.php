@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Member List</span></h4>

    <div class="my-3">
        <div class="row d-flex justify-content-end text-end">
            <span>
                <a href="/dashboard/member/list/create">
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
                    <h5 class="mb-0">Data Member List</h5>
                </div>

                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Member</th>
                                <th>No Kartu</th>
                                <th>Akses</th>
                                <th>Hp</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction_member as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->Nama }}</td>
                                    <td>{{ $item->serial }}</td>
                                    <td>{{ $item->Akses }}</td>
                                    <td>{{ $item->Hp }}</td>
                                    <td>
                                        @php
                                            $future_date = new DateTime($item->Awal_Aktif);
                                            $old_date = new DateTime($item->Akhir_Aktif);

                                            $interval = $future_date->diff($old_date);

                                            // echo $interval->format('%a days, %h hours, %i minutes, %s seconds');
                                            echo $interval->format('%a Hari');

                                        @endphp
                                    </td>
                                    <th>
                                        @if ($item->Status == 1)
                                            Aktif
                                        @else
                                            Tidak Aktif
                                        @endif
                                    </th>
                                    <td>
                                        <div class="row">
                                            <div class="col-3">
                                                <a href="/dashboard/member/list/edit/{{ encrypt($item->id) }}"
                                                    href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-2"></i>

                                                </a>

                                            </div>
                                            <div class="col-3">
                                                <a class=" deleteData" href="javascript:void(0);"
                                                    attr-id="{{ encrypt($item->id) }}">
                                                    <i class="bx bx-trash me-2"></i>
                                                </a>
                                            </div>
                                            <div class="col-3">
                                                <a href='' data-bs-toggle="modal"
                                                    data-bs-target="#modal_extend_member" attr-id="{{ encrypt($item->id) }}"
                                                    class="modal_extend_member_click">
                                                    <i class="fa-solid fa-address-card"></i>
                                                </a>

                                            </div>
                                            <div class="col-3">
                                                @if ($item->Status == 1)
                                                    <a class="memberActivation" attr-id="{{ encrypt($item->id) }}"
                                                        href="javascript:void(0);">
                                                        <i class="fa-solid fa-check" style="color: green"></i>
                                                    </a>
                                                @else
                                                    <a class="memberActivation" attr-id="{{ encrypt($item->id) }}"
                                                        href="javascript:void(0);">
                                                        <i class="fa-solid fa-xmark" style="color: red"></i>
                                                    </a>
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

    <!-- Modal -->
    <div class="modal fade" id="modal_extend_member" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Perpanjangan Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tanggal Berakhir Member</label>
                        <div class="input-group date">
                            <input class="form-control select-time-schedule" name="Akhir_Aktif" value="-"
                                readonly="readonly" id="Akhir_Aktif" />
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tanggal Perpanjangan
                            Member</label>
                        <div class="input-group date">
                            <input class="form-control select-time-schedule date_custom" name="member_data_extend"
                                id="member_data_extend" readonly />
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Biaya</label>
                        <input type="text" class="form-control" id="price_extend" placeholder="Biaya Perpanjangan"
                            readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_extend_member">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>

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
                        url: "/dashboard/member/list/delete/" + $(this)
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

        $(".memberActivation").click(function() {

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "Anda tidak akan dapat mengembalikannya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah Status!'
            }).then((result) => {
                if (result.isConfirmed) {

                    //delete action
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"),
                        },
                        type: "POST",
                        url: "/dashboard/member/list/changeStatus/" + $(".memberActivation")
                            .attr("attr-id"),
                        // data: data,
                        dataType: "json",
                        success: function(response) {
                            // console.log(response);
                            location.reload();

                            // if (response.status == 400) {

                            // } else {

                            // }
                        },
                    });

                    //delete alert
                    Swal.fire(
                        'Di Ubah!',
                        'Data berhasil diubah.',
                        'success'
                    )
                }
            })


        });


        $(document).ready(function() {

            var modal_extend_member_ID = '';

            $(".modal_extend_member_click").on("click", function() {
                // alert($(this).attr("attr-id"));
                modal_extend_member_ID = $(this).attr("attr-id");
                $("#member_data_extend").val('');
                $("#price_extend").val('');


                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "/dashboard/transaction/member/" + modal_extend_member_ID,
                    success: function(response) {
                        $("#Akhir_Aktif").val(response.transaction_member.Akhir_Aktif);
                    },
                });
            });

            $('#member_data_extend').on('change', function(e) {
                member_data_extend = new Date($("#member_data_extend").val());


                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "/dashboard/transaction/member/" + modal_extend_member_ID,
                    success: function(response) {

                        // console.log(response.transaction_member);

                        var Tarif_Dasar_Member =
                            response.transaction_member.Tarif_Dasar_Member.replaceAll(
                                /\D/g,
                                ""
                            );


                        var tarif_per_day = parseInt(Tarif_Dasar_Member) / 30;

                        // console.log(member_data_extend);

                        var start = new Date(response.transaction_member.Akhir_Aktif),
                            end = new Date(member_data_extend),
                            diff = new Date(end - start);

                        var diffDays = Math.floor(diff / 86400000); // days
                        var diffHrs = Math.floor((diff % 86400000) / 3600000); // hours

                        if (diffDays < 0) {
                            diffDays = 0;
                        }

                        tarif_per_day = Math.floor(tarif_per_day * diffDays);
                        tarif_per_day = formatRupiah(tarif_per_day.toString(), "Rp. ");
                        $("#price_extend").val(tarif_per_day);

                    },
                });

                // console.log(Akhir_Aktif);
            });

            $('#save_extend_member').on('click', function(e) {
                var date = new Date($("#member_data_extend").val()),
                    yr = date.getFullYear(),
                    month = date.getMonth() + 1,
                    day = date.getDate(),
                    newDate = yr + '-' + month + '-' + day;

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"),
                    },
                    type: "POST",
                    url: "/dashboard/transaction/memberExtendMember/" + modal_extend_member_ID,
                    data: {
                        member_data_extend: newDate,
                        member_data_tarif: $("#price_extend").val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        // if (response.status == 400) {

                        // } else {

                        // }

                        $('#modal_extend_member').modal('toggle');

                        //delete alert
                        Swal.fire(
                            'Sukses!',
                            'Data Berhasil Di Perpanjang.',
                            'success'
                        )

                        location.reload();

                    },
                });
            });


        });
    </script>

@endsection

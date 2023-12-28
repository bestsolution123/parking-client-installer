@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/member/list">Member List/</a></span>
        Edit Data</h4>

    <!-- Basic Layout -->
    <form method="POST" action="/dashboard/member/list/edit/{{ encrypt($transaction_member->id) }} "
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="Nama"
                                name="Nama" value="{{ $transaction_member->Nama }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Member</label>
                            <select class="form-control selectpicker d-block border" name="member_id" id="member_id"
                                id="mode_type" data-live-search="true">
                                <option value="" selected>Pilih Member</option>
                                <?php
                                            for($i = 0; $i < count($member); $i++){
                                               
                                            ?>
                                <option value="{{ $member[$i]->id }}"
                                    {{ $transaction_member->member_id == $member[$i]->id ? 'selected' : '' }}>
                                    {{ $member[$i]->Nama }}
                                </option>
                                <?php

                                        }

                                            ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Akses</label>
                            <select class="form-control selectpicker d-block border" name="Akses" id="mode_type"
                                data-live-search="true">
                                <option value="" selected>Pilih Akses</option>
                                <?php
                        $data = ['No Polisi', 'Tiket'];
                        for($i = 0; $i < count($data); $i++){
                            
                        ?>
                                <option value="{{ $data[$i] }}"
                                    {{ $transaction_member->Akses == $data[$i] ? 'selected' : '' }}>
                                    {{ $data[$i] }}
                                </option>
                                <?php

                            }

                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nomor Hp</label>
                            <input type="number" class="form-control" id="basic-default-fullname" placeholder=""
                                name="Hp" value="{{ $transaction_member->Hp }}" />
                        </div>


                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Email</label>
                            <input type="email" class="form-control" id="basic-default-fullname" placeholder="Email"
                                name="Email" value="{{ $transaction_member->Email }}" />
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Awal Aktif</label>

                            <div class="input-group date">
                                <input class="form-control select-time-schedule date_custom" name="Awal_Aktif"
                                    id="Awal_Aktif" value="{{ $transaction_member->Awal_Aktif }}" readonly="readonly" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Akhir Aktif</label>

                            <div class="input-group date">
                                <input class="form-control select-time-schedule" name="Akhir_Aktif" id="Akhir_Aktif"
                                    value="{{ $transaction_member->Akhir_Aktif }}" readonly="readonly" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div> --}}

                        <div class="mb-3 " id="data_nomor_polisi_parent">
                            <label class="form-label" for="basic-default-fullname">No Polisi <span style="color: red">
                                    ( Max </span> <span style="color: red" id="max_vehicle">1</span> <span
                                    style="color: red">
                                    Kendaraan )</span> </label>
                            @foreach ($transaction_member->member_plat_number as $item)
                                <input type="hidden" name="id_Plat_Number[]" value="{{ encrypt($item->id) }}">

                                <input type="text" class="form-control mb-3 data_nomor_polisi_item"
                                    id="data_nomor_polisi_item" placeholder="No Polisi" name="Plat_Number[]"
                                    value="{{ $item->plat_number }}" />
                            @endforeach
                        </div>

                        <div class="row text-end">
                            <div class="container">
                                <a>
                                    <button type="button" class="btn btn-primary"
                                        id="data_nomor_polisi_decrease">-</button>
                                </a>
                                <a>
                                    <button type="button" class="btn btn-primary"
                                        id="data_nomor_polisi_increase">+</button>
                                </a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="result_vehicle_id" value="-" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Periode</label>
                            <input type="text" class="form-control" id="result_Periode" value="-" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Biaya Kartu</label>
                            <input type="text" class="form-control" id="result_Biaya_Kartu" name="Tarif_Kartu"
                                value="-" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Biaya Dasar Member</label>
                            <input type="text" class="form-control" id="Tarif_Dasar_Member" name="Tarif_Dasar_Member"
                                value="-" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname" id="caption_price_member">Biaya
                                Member</label>
                            <input type="text" class="form-control" id="result_Tarif" name="Tarif_Member"
                                value="-" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Total</label>
                            <input type="text" class="form-control" id="result_Total" name="Total_Biaya"
                                value="-" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>


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
        $(document).ready(function() {
            var Periode = 0;
            var Awal_Aktif = new Date($("#Awal_Aktif").val());
            var Akhir_Aktif = new Date();
            var Max_Kendaraan = 0;

            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/dashboard/memberId/" + $("#member_id").val(),
                success: function(response) {
                    // console.log(response.member.Periode);

                    Max_Kendaraan = response.member.Max_Kendaraan;
                    $("#max_vehicle").text(++response.member.Max_Kendaraan);

                    Awal_Aktif = new Date($("#Awal_Aktif").val());
                    Periode = parseInt(response.member.Periode) * 30;

                    Akhir_Aktif = Awal_Aktif;
                    Akhir_Aktif.setDate(Awal_Aktif.getDate() + Periode);
                    const year = Akhir_Aktif.toLocaleString('default', {
                        year: 'numeric'
                    });
                    const month = Akhir_Aktif.toLocaleString('default', {
                        month: '2-digit',
                    });

                    const day = Akhir_Aktif.toLocaleString('default', {
                        day: '2-digit'
                    });

                    $("#Akhir_Aktif").val(year + '-' + month + '-' + day);
                    // console.log(Akhir_Aktif);

                    //result member
                    $("#result_Biaya_Kartu").val(response.member
                        .Biaya_Kartu);

                    $("#Tarif_Dasar_Member").val(response.member
                        .Tarif);

                    var tarif_result = response.member
                        .Tarif.replaceAll(
                            /\D/g,
                            ""
                        );
                    tarif_result = tarif_result * parseInt(response.member
                        .Periode);

                    var result_Total = tarif_result + parseInt(response.member
                        .Biaya_Kartu.replaceAll(
                            /\D/g,
                            ""
                        ));

                    tarif_result = formatRupiah(tarif_result.toString(), "Rp. ");
                    result_Total = formatRupiah(result_Total.toString(), "Rp. ");

                    $("#caption_price_member").text("Biaya Member " + response.member
                        .Periode + " Bulan");
                    $("#result_Periode").val(response.member
                        .Periode + " Bulan");
                    $("#result_Tarif").val(tarif_result);
                    $("#result_Total").val(result_Total);
                    $("#result_vehicle_id").val(response.member
                        .vehicle.name);
                },
            });

            $('#Awal_Aktif').on('change', function(e) {
                Awal_Aktif = new Date($("#Awal_Aktif").val());

                Akhir_Aktif = Awal_Aktif;
                Akhir_Aktif.setDate(Awal_Aktif.getDate() + Periode);
                const year = Akhir_Aktif.toLocaleString('default', {
                    year: 'numeric'
                });

                const month = Akhir_Aktif.toLocaleString('default', {
                    month: '2-digit',
                });

                const day = Akhir_Aktif.toLocaleString('default', {
                    day: '2-digit'
                });

                $("#Akhir_Aktif").val(year + '-' + month + '-' + day);

                // console.log(Akhir_Aktif);
            });

            // data plat number
            $("#data_nomor_polisi_decrease").click(function() {
                if ($(".data_nomor_polisi_item").length > 1) {
                    $(".data_nomor_polisi_item").last().remove();
                }
            });

            $("#data_nomor_polisi_increase").click(function() {
                if ($(".data_nomor_polisi_item").length <= Max_Kendaraan) {
                    $("#data_nomor_polisi_item").clone().appendTo("#data_nomor_polisi_parent").val("");
                }
            });

        });
    </script>

@endsection

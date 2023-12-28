@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/voucher/list">Voucher List/</a></span>
        Edit Data</h4>

    <!-- Basic Layout -->
    <form method="POST" action="/dashboard/voucher/list/edit/{{ encrypt($transaction_voucher->id) }} "
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
                            <label class="form-label" for="basic-default-fullname">Produk</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="Produk"
                                name="Produk" value="{{ $transaction_voucher->Produk }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Voucher</label>
                            <select class="form-control selectpicker d-block border" name="voucher_id" id="voucher_id"
                                data-live-search="true">
                                <option value="">Pilih Voucher</option>
                                <?php
                                        for($i = 0; $i < count($voucher); $i++){
                                           
                                        ?>
                                <option value="{{ $voucher[$i]->id }}"
                                    {{ $transaction_voucher->voucher_id == $voucher[$i]->id ? 'selected' : '' }}>
                                    {{ $voucher[$i]->Nama }}
                                </option>
                                <?php

                                    }

                                        ?>
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Awal Aktif</label>

                            <div class="input-group date">
                                <input class="form-control select-time-schedule date_custom" name="Awal_Aktif"
                                    id="Awal_Aktif" value="{{ $transaction_voucher->Awal_Aktif }}" readonly="readonly" />
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
                                    value="{{ $transaction_voucher->Akhir_Aktif }}" readonly="readonly" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Keterangan</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="Keterangan"
                                name="Keterangan" value=" {{ $transaction_voucher->Keterangan }}" />
                        </div>

                        <div class="mb-3 " id="data_nomor_polisi_parent">
                            <label class="form-label" for="basic-default-fullname">No Polisi</label>
                            @foreach ($transaction_voucher->voucher_plat_number as $item)
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
                            <label class="form-label" for="basic-default-fullname">Periode</label>
                            <input type="text" class="form-control" id="result_Periode" value="-" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Biaya Dasar Voucher</label>
                            <input type="text" class="form-control" id="Tarif_Dasar_Voucher" name="Tarif_Dasar_Voucher"
                                value="-" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname" id="caption_Tarif_Voucher">Biaya
                                Voucher</label>
                            <input type="text" class="form-control" id="result_Tarif" name="Tarif" value="-" />
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

            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/dashboard/voicherId/" + $("#voucher_id").val(),
                success: function(response) {
                    // console.log(response.voucher.Periode);
                    Awal_Aktif = new Date($("#Awal_Aktif").val());
                    Periode = parseInt(response.voucher.Periode);

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

                    //result voucher
                    $("#Tarif_Dasar_Voucher").val(response.voucher
                        .Tarif);
                    $("#result_Periode").val(response.voucher
                        .Periode + " Hari");

                    var tarif_result = response.voucher
                        .Tarif.replaceAll(
                            /\D/g,
                            ""
                        );

                    tarif_result = tarif_result * parseInt(response.voucher
                        .Periode);

                    tarif_result = formatRupiah(tarif_result.toString(), "Rp. ");
                    result_Total = formatRupiah(tarif_result.toString(), "Rp. ");

                    $("#caption_Tarif_Voucher").text("Biaya Voucher " +
                        response.voucher
                        .Periode + " Hari");
                    $("#result_Tarif").val(tarif_result);
                    $("#result_Total").val(result_Total);
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
                $("#data_nomor_polisi_item").clone().appendTo("#data_nomor_polisi_parent").val("");
            });

        });
    </script>

@endsection

@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/siteGateParking">Gerbang
                Parkir/</a></span>
        Edit Data</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
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
                    <form method="POST" action="/dashboard/siteGateParking/edit/{{ encrypt($site_gate_parking->id) }} "
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="Nama"
                                name="name" value="{{ $site_gate_parking->name }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Type Gerbang</label>
                            <select class="form-control selectpicker d-block border" name="type" id="type"
                                data-live-search="true">
                                <?php
                                    $data = ['Masuk', 'Keluar'];
                                    for($i = 0; $i < count($data); $i++){
                                ?>
                                <option value="{{ $data[$i] }}"
                                    {{ $data[$i] == $site_gate_parking->type ? 'selected' : '' }}>
                                    {{ $data[$i] }}
                                </option>
                                <?php

                                                    }

                                                        ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Alamat</label>

                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Masukan Alamat" id="floatingTextarea" name="address">{{ $site_gate_parking->address }}</textarea>
                                <label for="floatingTextarea">Masukan Alamat</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Jenis Metode Pembayaran</label>
                            <select class="form-control selectpicker d-block border" name="type_payment" id="type_payment"
                                data-live-search="true">
                                <option value="" selected>Pilih Jenis Metode Pembayaran</option>
                                <?php
                                        $data = ['Manual', 'Manless'];
                                        for($i = 0; $i < count($data); $i++){
                                           
                                        ?>
                                <option value="{{ $data[$i] }}"
                                    {{ $site_gate_parking->type_payment == $data[$i] ? 'selected' : '' }}>
                                    {{ $data[$i] }}
                                </option>
                                <?php

                                    }

                                        ?>
                            </select>
                        </div>

                        <div class="mb-3 payment_method_manless" style="display:none">
                            <div id="manless_payment_parent">
                                <label class="form-label" for="basic-default-fullname">Metode Pembayaran</label>
                                @if (count($site_gate_parking->siteGateParkingPayment) != 0)
                                    @foreach ($site_gate_parking->siteGateParkingPayment as $item)
                                        <div class="manless_payment_item mb-3" id="manless_payment_item">
                                            <input type="hidden" name="id_manless_payment_id[]"
                                                value="{{ encrypt($item->id) }}">

                                            <select class="form-control selectpicker d-block border"
                                                name="manless_payment_id[]" id="manless_payment_id" data-live-search="true">
                                                <?php
                                for($i = 0; $i < count($manlessPayment); $i++){
                                   
                                ?>
                                                <option value="{{ $manlessPayment[$i]->id }}"
                                                    {{ $manlessPayment[$i]->id == $item->manless_payment_id ? 'selected' : '' }}>
                                                    {{ $manlessPayment[$i]->name }}
                                                </option>
                                                <?php

                            }

                                ?>
                                            </select>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="manless_payment_item mb-3" id="manless_payment_item">
                                        <select class="form-control selectpicker d-block border" name="manless_payment_id[]"
                                            id="manless_payment_id" data-live-search="true">
                                            <option value="" selected>Pilih Metode Pembayaran</option>
                                            <?php
                                    for($i = 0; $i < count($manlessPayment); $i++){
                                       
                                    ?>
                                            <option value="{{ $manlessPayment[$i]->id }}">
                                                {{ $manlessPayment[$i]->name }}
                                            </option>
                                            <?php

                                }

                                    ?>
                                        </select>
                                    </div>
                                @endif

                            </div>


                            <div class="row text-end">
                                <div class="container">
                                    <a>
                                        <button type="button" class="btn btn-primary"
                                            id="manless_payment_item_decrease">-</button>
                                    </a>
                                    <a>
                                        <button type="button" class="btn btn-primary"
                                            id="manless_payment_item_increase">+</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Printer</label>
                            <select class="form-control selectpicker d-block border" name="printer_id" id="printer_id"
                                data-live-search="true">
                                <?php
                                                        for($i = 0; $i < count($printer); $i++){
                                                           
                                                        ?>
                                <option value="{{ $printer[$i]->id }}"
                                    {{ $printer[$i]->id == $site_gate_parking->printer->id ? 'selected' : '' }}>
                                    {{ $printer[$i]->name }}
                                </option>
                                <?php

                                                    }

                                                        ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Peruntukan Jenis kendaraan</label>
                            <select class="form-control selectpicker d-block border" name="vehicle_id" id="vehicle_id"
                                data-live-search="true">
                                <?php
                                                        for($i = 0; $i < count($vehicle); $i++){
                                                           
                                                        ?>
                                <option value="{{ $vehicle[$i]->id }}"
                                    {{ $vehicle[$i]->id == $site_gate_parking->vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle[$i]->name }}
                                </option>
                                <?php

                                                    }

                                                        ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Printer Settings</label>
                            <?php
                                                        for($i = 0; $i < count($site_gate_parking->printer_setting); $i++){
                                                           
                                                        ?>
                            <div class="form-check">
                                <input type="hidden" name="printer_settings_name[]"
                                    value="{{ $site_gate_parking->printer_setting[$i]['name'] }}" id="">
                                <input type="hidden" name="printer_settings_id{{ $i }}"
                                    value="{{ encrypt($site_gate_parking->printer_setting[$i]['id']) }}" id="">
                                <input class="form-check-input" type="checkbox"
                                    name="printer_settings_isOn{{ $i }}" value="on" id="flexCheckChecked"
                                    {{ $site_gate_parking->printer_setting[$i]['is_on'] == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckChecked">
                                    {{ $site_gate_parking->printer_setting[$i]['name'] }}
                                </label>
                            </div>
                            <?php

                                                    }

                                                        ?>

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Cetak Struk Gerbang Keluar
                                Otomatis</label>
                            <div class="form-floating">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="is_print" {{ $site_gate_parking->is_print == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {

            if ($("#type_payment").val() == "Manless") {
                $(".payment_method_manless").show();
            } else {
                $(".payment_method_manless").hide();

            }

            $("#type_payment").on("change", function() {
                if ($("#type_payment").val() == "Manless") {
                    $(".payment_method_manless").show();
                } else {
                    $(".payment_method_manless").hide();

                }
            });


            // data payment
            var data_type_payment = ['Manual', 'Manless'];

            $("#manless_payment_item_decrease").click(function() {
                if ($(".manless_payment_item").length > 1) {
                    $(".manless_payment_item").last().remove();
                }
            });

            $("#manless_payment_item_increase").click(function() {
                $cloned = $("#manless_payment_item").clone().appendTo("#manless_payment_parent");
                $('.selectpicker').selectpicker();
                $cloned.find('.dropdown-toggle')[1].remove();
            });

        });
    </script>

@endsection

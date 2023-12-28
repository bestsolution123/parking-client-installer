@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/voucher">Voucher/</a></span>
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
                    <form method="POST" action="/dashboard/voucher/edit/{{ encrypt($voucher->id) }} "
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama Voucher</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                placeholder="Nama Voucher" name="Nama" value="{{ $voucher->Nama }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Periode</label>

                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="Masukan Periode"
                                    aria-label="Recipient's username" aria-describedby="basic-addon2" name="Periode"
                                    min="1" value="{{ $voucher->Periode }}">
                                <span class="input-group-text" id="basic-addon2">Hari</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Kendaraan</label>
                            <select class="form-control selectpicker d-block border" name="vehicle_id" id="vehicle_id"
                                data-live-search="true">
                                <?php
                                                    for($i = 0; $i < count($vehicle); $i++){
                                                       
                                                    ?>
                                <option value="{{ $vehicle[$i]->id }}"
                                    {{ $vehicle[$i]->id == $voucher->vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle[$i]->name }}
                                </option>
                                <?php

                                                }

                                                    ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Tarif</label>
                            <input type="text" class="form-control" id="dengan-rupiah" placeholder="Tarif" name="Tarif"
                                value="{{ $voucher->Tarif }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Model Pembayaran</label>
                            <select class="form-control selectpicker d-block border" name="Model_Pembayaran" id="mode_type"
                                data-live-search="true">
                                <option value="" selected>Pilih Model Pembayaran</option>
                                <?php
                            $data = ['Check In', 'Check Out'];
                            for($i = 0; $i < count($data); $i++){
                                
                            ?>
                                <option value="{{ $data[$i] }}"
                                    {{ $voucher->Model_Pembayaran == $data[$i] ? 'selected' : '' }}>
                                    {{ $data[$i] }}
                                </option>
                                <?php
    
                                }
    
                                    ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Metode Verifikasi</label>

                            <select class="form-control selectpicker d-block border" name="Metode_Verifikasi" id="mode_type"
                                data-live-search="true">
                                <option value="" selected>Pilih Metode Verifikasi</option>
                                <?php
                            $data = ['No Polisi', 'Tiket'];
                            for($i = 0; $i < count($data); $i++){
                                
                            ?>
                                <option value="{{ $data[$i] }}"
                                    {{ $voucher->Metode_Verifikasi == $data[$i] ? 'selected' : '' }}>
                                    {{ $data[$i] }}
                                </option>
                                <?php
    
                                }
    
                                    ?>
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Status</label>
                            <select class="form-control selectpicker d-block border" name="Status" id="mode_type"
                                data-live-search="true">
                                <option value="" selected>Pilih Status</option>
                                <?php
                            $data = ['Aktif', 'Tidak Aktif'];
                            for($i = 0; $i < count($data); $i++){
                                
                            ?>
                                <option value="{{ $data[$i] }}" {{ $voucher->Status == $data[$i] ? 'selected' : '' }}>
                                    {{ $data[$i] }}
                                </option>
                                <?php
    
                                }
    
                                    ?>
                            </select>
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </form>
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

@endsection

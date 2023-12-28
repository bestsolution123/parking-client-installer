@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/vehicle">Kendaraan
                /</a></span>
        Tambah Data</h4>

    <!-- Basic Layout -->
    <div class="row">

        <div class="col-xl">
            @if (session()->has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('danger') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
                    <form method="POST" action="/dashboard/vehicle/create" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Jenis Kendaraan</label>
                            <select class="form-control selectpicker d-block border" name="vehicle_initial_id"
                                id="mode_type" data-live-search="true">
                                <option value="" selected>Pilih Jenis Kendaraan</option>
                                <?php
                                            for($i = 0; $i < count($vehicle_initial); $i++){
                                               
                                            ?>
                                <option value="{{ $vehicle_initial[$i]->id }}">
                                    {{ $vehicle_initial[$i]->name }}
                                </option>
                                <?php

                                        }

                                            ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Tipe Kendaraan</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                placeholder="Tipe Kendaraan" name="name" value="{{ old('name') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Harga Jam Ke 1</label>
                            <input type="text" class="form-control" id="dengan-rupiah" placeholder="Harga Jam Ke 1"
                                name="time_price_1" value="{{ old('time_price_1') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Harga Jam Ke 2</label>
                            <input type="text" class="form-control" id="dengan-rupiah-2" placeholder="Harga Jam Ke 2"
                                name="time_price_2" value="{{ old('time_price_2') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Harga Jam Ke 3</label>
                            <input type="text" class="form-control" id="dengan-rupiah-3" placeholder="Harga Jam Ke 3"
                                name="time_price_3" value="{{ old('time_price_3') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Harga Sebelum Jam Ke 1</label>
                            <input type="text" class="form-control" id="dengan-rupiah-4"
                                placeholder="Harga Sebelum Jam Ke 1" name="grace_time" value="{{ old('grace_time') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Maximal Durasi Untuk Harga Sebelum Jam ke
                                1 </label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="basic-default-fullname"
                                    placeholder="Hitungan Dalam Menit" name="grace_time_duration"
                                    value="{{ old('grace_time_duration') }}" max="60" />
                                <span class="input-group-text" id="basic-addon2">Menit</span>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname"> Peringanan Waktu Pembayaran </label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="basic-default-fullname"
                                    placeholder="Hitungan Dalam Menit" name="limitation_time_duration"
                                    value="{{ old('limitation_time_duration') }}" max="60" />
                                <span class="input-group-text" id="basic-addon2">Menit</span>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Opsi Maksimal Harga Per / Hari</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="maximum_daily"
                                    name="maximum_daily">Checklis Untuk Mengaktifkan Fitur Batas Maximal
                                Harian</label>
                            </div>
                        </div>
                        <div class="mb-3" id="batas_maximal_prices">
                            <label class="form-label" for="basic-default-fullname">Batas Maksimal Harga Per / Hari
                            </label>
                            <input type="text" class="form-control" placeholder="Batas Maksimal Harga Per / Hari "
                                name="maximum_daily_price" value="{{ old('maximum_daily_price') }}"
                                id="dengan-rupiah-5" />
                        </div>
                        <button type="submit" class="btn btn-primary">Buat Data</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $("#batas_maximal_prices").hide();

            $('#maximum_daily').change(function() {
                if ($(this).prop('checked')) {
                    $("#batas_maximal_prices").show();
                } else {
                    $("#batas_maximal_prices").hide();
                }
            })

        });
    </script>

@endsection

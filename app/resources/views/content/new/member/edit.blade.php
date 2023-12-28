@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/member">Member/</a></span>
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
                    <form method="POST" action="/dashboard/member/edit/{{ encrypt($member->id) }} "
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama Member</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="Nama Member"
                                name="Nama" value="{{ $member->Nama }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Periode</label>

                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="Masukan Periode"
                                    aria-label="Recipient's username" aria-describedby="basic-addon2" name="Periode"
                                    min="1" value="{{ $member->Periode }}">
                                <span class="input-group-text" id="basic-addon2">Bulan</span>
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
                                    {{ $vehicle[$i]->id == $member->vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle[$i]->name }}
                                </option>
                                <?php

                                                                                                    }

                                                                                                        ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Max Kendaraan</label>
                            <input type="number" class="form-control" id="basic-default-fullname"
                                placeholder="Nama Max Kendaraan" name="Max_Kendaraan" value="{{ $member->Max_Kendaraan }}"
                                min="1" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Biaya Member</label>
                            <input type="text" id="dengan-rupiah" class="form-control" placeholder="Biaya Member"
                                name="Tarif" value="{{ $member->Tarif }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Biaya Kartu</label>
                            <input type="text" id="dengan-rupiah-2" class="form-control" placeholder="Biaya Kartu"
                                name="Biaya_Kartu" value="{{ $member->Biaya_Kartu }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Biaya Ganti No Polisi</label>
                            <input type="text" class="form-control" id="dengan-rupiah-3"
                                placeholder="Biaya Ganti No Polisi" name="Biaya_Ganti_Plat_Number"
                                value="{{ $member->Biaya_Ganti_Plat_Number }}" />
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
                                <option value="{{ $data[$i] }}" {{ $member->Status == $data[$i] ? 'selected' : '' }}>
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

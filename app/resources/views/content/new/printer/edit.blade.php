@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/printer">Printer/</a></span>
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
                    <form method="POST" action="/dashboard/printer/edit/{{ encrypt($printer->id) }} "
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama Printer</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                placeholder="Nama Printer" name="name" value="{{ $printer->name }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Name Sharing Printer / Alamat IP
                                Printer</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                placeholder="Name Sharing Printer / Alamat IP Printer" name="address"
                                value="{{ $printer->address }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Jenis Koneksi</label>
                            <select class="form-control selectpicker d-block border" name="type_connection" id="mode_type"
                                data-live-search="true">
                                <?php
                            $data = ['LAN', 'USB'];
                        for($i = 0; $i < count($data); $i++){
                            if($data[$i] == $printer->name)
                            {
                        ?>
                                <option value="{{ $data[$i] }}" selected>
                                    {{ $data[$i] }}
                                </option>
                                <?php
                    }else{
                        ?>
                                <option value="{{ $data[$i] }}">
                                    {{ $data[$i] }}
                                </option>
                                <?php 
                        }

                    }

                        ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Ukuran Kertas</label>
                            <select class="form-control selectpicker d-block border" name="paper_size" id="mode_type"
                                data-live-search="true">
                                <?php
                        $data = ['55', '80'];
                        for($i = 0; $i < count($data); $i++){
                            if($data[$i] == $printer->paper_size)
                            {
                        ?>
                                <option value="{{ $data[$i] }}" selected>
                                    {{ $data[$i] }}
                                </option>
                                <?php
                    }else{
                        ?>
                                <option value="{{ $data[$i] }}">
                                    {{ $data[$i] }}
                                </option>
                                <?php 
                        }

                    }

                        ?>
                            </select>
                        </div>
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

@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/manlessPayment">Pembayaran
                /</a></span>
        Tambah Data</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl-6">
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
                    <form method="POST" action="/dashboard/manlessPayment/create" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama Pembayaran</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                placeholder="Nama Pembayaran" name="name" value="{{ old('name') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Tipe Pembayaran</label>
                            <select class="form-control selectpicker d-block border" name="payment_type" id="payment_type"
                                data-live-search="true">
                                <option value="" selected>Pilih Tipe Pembayaran</option>
                                <?php
                            // $data = ['Virtual Account', 'Convenience Store', 'COD', 'QRIS', 'Credit Card'];
                            // $content = ['va', 'cstore', 'cod', 'qris', 'cc'];

                            $data = ['QRIS', 'E-Money / Flash / Breezy'];
                            $content = ['qris', 'emoney'];
                            for($i = 0; $i < count($data); $i++){
                                
                            ?>
                                <option value="{{ $content[$i] }}">
                                    {{ $data[$i] }}
                                </option>
                                <?php
    
                                }
    
                                    ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Jenis Pembayaran</label>
                            <select class="form-select form-select d-block border" name="payment_bank" id="payment_bank"
                                data-live-search="true">
                                <option value="" selected>Pilih Jenis Pembayaran</option>
                            </select>

                        </div>
                        <button type="submit" class="btn btn-primary">Buat Data</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Alat Yang Harus Di Sediakan</label>
                        <div id="tool_payments">
                            <input type="text" class="form-control" value="-" readonly />
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $("#payment_type").on("change", function() {

                $("#payment_bank").empty();
                $("#payment_bank").append(
                    "<option value=''>Pilih Jenis Pembayaran</option>"
                );

                $("#tool_payments").empty();

                var data = [];
                var content = [];

                if ($("#payment_type").val() == "va") {
                    data = ['BAG', 'BCA', 'BNI', 'Cimb Niaga', 'Mandiri', 'Muamalat', 'BRI', 'BSI',
                        'Permata', 'Danamon'
                    ];
                    content = ['bag', 'bca', 'bni', 'cimb', 'mandiri', 'bmi', 'bri', 'bsi',
                        'permata',
                        'danamon'
                    ];
                    tools = ['-'];
                } else if ($("#payment_type").val() == "cstore") {
                    data = ['Alfamart', 'Indomaret'];
                    content = ['alfamart', 'indomaret'];
                    tools = ['-'];

                } else if ($("#payment_type").val() == "cod") {
                    data = ['Kurir RPX'];
                    content = ['rpx'];
                    tools = ['-'];

                } else if ($("#payment_type").val() == "qris") {
                    data = ['qris'];
                    content = ['qris'];
                    tools = ['Mini Pc', 'EDC + Screen / EDC + Monitor', 'Scanner', 'Printer', 'Jaringan'];

                } else if ($("#payment_type").val() == "cc") {
                    data = ['cc'];
                    content = ['cc'];
                    tools = ['-'];

                } else if ($("#payment_type").val() == "emoney") {
                    data = ['emoney'];
                    content = ['emoney'];
                    tools = ['Mini Pc', 'Scanner', 'Printer', 'Jaringan'];
                }


                for (let i = 0; i < data.length; i++) {

                    $("#payment_bank").append(
                        "<option value='" + content[i] + "'>" + data[i] +
                        "</option>"
                    );
                }

                for (let i = 0; i < tools.length; i++) {

                    $("#tool_payments").append(
                        "<input type='text' class='form-control mb-3' value='" + tools[i] +
                        "' readonly />"
                    );

                }


            });
        });
    </script>

@endsection

@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/vehicle">Kendaraan
                /</a></span>
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
                    <form method="POST" action="/dashboard/punishment/edit/{{ encrypt($punishment->id) }} "
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Jenis Hukuman</label>
                            <input type="text" class="form-control" placeholder="Jenis Hukuman" name="name"
                                value="{{ $punishment->name }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nominal Denda</label>
                            <input type="text" class="form-control" id="dengan-rupiah" placeholder="Nominal Denda"
                                name="price" value="{{ $punishment->price }}" />
                        </div>
                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {

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

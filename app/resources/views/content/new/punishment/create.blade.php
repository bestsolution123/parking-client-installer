@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/vehicle">Kendaraan
                /</a></span>
        Tambah Data</h4>

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
                    <form method="POST" action="/dashboard/punishment/create" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Jenis Hukuman</label>
                            <input type="text" class="form-control" placeholder="Jenis Hukuman" name="name"
                                value="{{ old('name') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nominal Denda</label>
                            <input type="text" class="form-control" id="dengan-rupiah" placeholder="Nominal Denda"
                                name="price" value="{{ old('price') }}" />
                        </div>

                        <button type="submit" class="btn btn-primary">Buat Data</button>
                    </form>
                </div>
            </div>
        </div>

    </div>


@endsection

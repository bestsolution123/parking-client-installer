@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dashboard/auth">User
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
                    <form method="POST" action="/dashboard/auth/edit/{{ encrypt($user->id) }} "
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama User</label>
                            <input type="text" class="form-control" id="basic-default-fullname" placeholder="Nama User"
                                name="name" value="{{ $user->name }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Email</label>
                            <input type="email" class="form-control" id="basic-default-fullname" placeholder="Email"
                                name="email" value="{{ $user->email }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Gerbang</label>
                            <select class="form-control selectpicker d-block border" name="site_gate_parking_id"
                                id="mode_type" data-live-search="true">
                                <option value="" selected>Pilih Gerbang</option>
                                <?php
                                foreach($site_gate_parking as $item){
                                    
                                ?>
                                <option value="{{ $item->id }}"
                                    {{ $user->site_gate_parking_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} / {{ $item->type }} / {{ $item->type_payment }}
                                </option>
                                <?php
        
                                    }

                                        ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Tingkatan Akses</label>
                            <select class="form-control selectpicker d-block border" name="role" id="mode_type"
                                data-live-search="true">
                                <?php
                                $data = ['editor', 'author'];
                            for($i = 0; $i < count($data); $i++){
                                if($data[$i] == $user->role)
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
                            <label class="form-label" for="basic-default-fullname">Time Zone</label>
                            <select class="form-control selectpicker d-block border" name="timeZone" id="mode_type"
                                data-live-search="true">
                                <option value="" selected>Pilih Time Zone</option>
                                <?php
                                $data = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                for($i = 0; $i < count($data); $i++){
                                    
                                ?>
                                <option value="{{ $data[$i] }}" {{ $user->timeZone == $data[$i] ? 'selected' : '' }}>
                                    {{ $data[$i] }}
                                </option>
                                <?php
        
                                    }

                                        ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                    name="password" />
                                <span class="input-group-text cursor-pointer" id="show_password"><i class="bx bx-hide"
                                        id="icon_show_password"></i></span>
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
            var showPassword = false;
            $("#show_password").click(function() {
                if (showPassword == false) {
                    $("#password").attr("type", 'text');
                    showPassword = true;
                    $("#icon_show_password").removeClass("bx bx-hide").addClass("bx bx-show");

                } else {
                    $("#password").attr("type", 'password');
                    showPassword = false;
                    $("#icon_show_password").removeClass("bx bx-show").addClass("bx bx-hide");

                }
            });
        });
    </script>

@endsection

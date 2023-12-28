<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: url("/assets/img/bg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="position-relative" style="height: 100vh; width: 100vw">
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="mb-3">

                <audio controls style="opacity: 0" id="playAudio">
                    <source src="/assets/audio/welcome.mp3" type="audio/mpeg">
                </audio>

                <input type="hidden" name="gate_name" id="gate_name" value="{{ encrypt($site_gate_parking->name) }}" />
                <input type="hidden" name="gate_id" id="gate_id" value="{{ encrypt($site_gate_parking->id) }}" />
                <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}" />
                <input type="name" name="value_scan" id="value_scan" autofocus />
            </div>
        </div>
    </div>

    <script src="/assets/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="/assets/js/sweetalert2.all.min.js"></script>
    <link href="/assets/js/sweetalert2.min.css" rel="stylesheet" />
    <script src="/assets/js/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(window).keypress(function(e) {
            var key = [];
            key = e.key;
            // console.log(e.key);
            if (/^0/.test(key)) {
                key = key.replace(/^0/, "");
                $("#value_scan").attr("value", key);
            }
        });

        //do something
        $("input[name=value_scan]").change(function() {
            if ($("#value_scan").val() == "0005089843") {

                Swal.fire({
                    icon: "success",
                    title: "Akses Parkir Tervalidasi",
                    text: "Silahkan Masuk",
                    showConfirmButton: false,
                    timer: 3000,
                });

            } else if ($("#value_scan").val() == "123") {
                $('#playAudio')[0].play();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Akses Parkir Tidak Tervalidasi",
                    showConfirmButton: false,
                    timer: 3000,
                });
            }
            $("#value_scan").val("");
        });
    </script>

    <script>
        var count_data = 0;

        setInterval(function() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/api/serial_comunication_index",
                success: function(response) {
                    // console.log(response[0].name);
                    // console.log(count_data);
                    if (count_data != response.length) {
                        if (response[0].name == 'print') {
                            $(document).ready(function() {
                                $('#playAudio')[0].play();
                                $.ajax({
                                    type: "GET",
                                    dataType: "json",
                                    url: "/dashboard/getTransactionLatest",
                                    success: function(response) {
                                        console.log(response.length + 1);
                                        //create transaction
                                        $.ajax({
                                            headers: {
                                                "X-CSRF-TOKEN": $(
                                                    'meta[name="csrf-token"]'
                                                ).attr(
                                                    "content"),
                                            },
                                            type: "POST",
                                            url: "/gate/scanners",
                                            data: {
                                                user_id: $("#user_id")
                                                    .val(),
                                                gate_name: $("#gate_name")
                                                    .val(),
                                                number: response.length + 1,
                                                plat_number: 'asdasdasdasdasd',
                                            },
                                            dataType: "json",
                                            success: function(response_2) {
                                                console.log(response_2);

                                                //print tiket
                                                $.ajax({
                                                    type: "GET",
                                                    dataType: "json",
                                                    url: "/gate/printParking/" +
                                                        $(
                                                            "#gate_id"
                                                        )
                                                        .val() +
                                                        "/" +
                                                        response_2
                                                        .id,
                                                    success: function(
                                                        response
                                                    ) {
                                                        console
                                                            .log(
                                                                response
                                                            );
                                                    },
                                                });
                                            },
                                        });
                                    },
                                });

                            });
                        }
                        count_data = response.length;
                    }
                },
            });
        }, 100);
    </script>
</body>

</html>

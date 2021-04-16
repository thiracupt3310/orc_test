<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Automatic ID Card Extraction</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/compressorjs/1.0.7/compressor.min.js" integrity="sha512-ZNlHFR9FBdeIlhwh040g5JmmYj7DQOwkqb9Y+DBJ1MaTzRMxKZkfHWkQU/dazDn9XRriajfh7ZGFksBKeUCsCg==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <style>
        label {
            font-weight: bold;
            margin-top: 5%;
        }

        .spinner {
            position: fixed;
            z-index: 1031;
            top: 50%;
            right: 50%;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body>
    <div id="myModal" class="modal">
        <div id="spinner" class="spinner-border spinner mb-3" role="status"></div>
    </div>

    <nav class="navbar justify-content-center" style="background-color: #BDBDBD;">
        <h2>Automatic ID Card Extraction</h2>
    </nav>

    <div class="row mt-3 ">
        <div class="col-12 col-md-6 ">

            <div class="container">
                <img id="profileImg" class="rounded mx-auto d-block" style="width: 150px;height: auto" src="./icon/id-card.svg">
                <input class="form-control mt-2" type="file" id="formFile" onchange="readURL(this)">
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">

            <div class="container">
                <img id="imageCrop" class="rounded mx-auto d-block" src="./icon/id_pic.svg" style="width: 100px;height: auto" /><br>


                <label for="id">ID Card Number</label>
                <input class="form-control" type="text" placeholder="ID Card Number" aria-label="default input example" id="id">

                <label for="firstname">Firstname</label>
                <input class="form-control" type="text" placeholder="Firstname " aria-label="default input example" id="firstname">

                <label for="lastname">Lastname</label>
                <input class="form-control" type="text" placeholder="Lastname" aria-label="default input example" id="lastname">

                <label for="dateOfBirth">Date Of Birth</label>
                <input class="form-control" type="text" placeholder="Date of Birth" aria-label="default input example" id="dateOfBirth">

            </div>
            <div class="text-center">

                <button id="myBtn" onclick="resetData()" class="btn btn-outline-primary mt-5" style="width: 70%"><i class="fas fa-sync-alt"></i> reset</button>
                <button class="btn btn-primary mt-2" style="width: 70%">Confirm</button>
            </div>

        </div>
    </div>

</body>
<script>
    let imageFile

    var max_width = 200;
    var max_height = 200;

    function parseTextHandle() {
        $("#myModal").show();

        $("#id").val("");
        $("#firstname").val("");
        $("#lastname").val("");
        $("#dateOfBirth").val("");
        $("#imageCrop").attr('src', "./icon/id_pic.svg");

        if (imageFile != undefined) {

            let fd = new FormData();

            fd.append('image', imageFile);
            fd.append('_token', "{{ csrf_token() }}")
            $.ajax({
                //create an ajax request to display.php
                type: "POST",
                url: "{{ url('/parse2Text') }}",
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.name) {
                        $("#firstname").val(response.name);
                    }
                    if (response.id) {
                        $("#id").val(response.id);
                    }

                    if (response.lastname) {
                        $("#lastname").val(response.lastname);
                    }

                    if (response.birthday) {
                        $("#dateOfBirth").val(response.birthday);
                    }

                    if (response.image) {
                        $("#imageCrop").attr('src', response.image);
                    }

                    $("#myModal").hide();
                },
                error: function(e) {
                    $("#myModal").hide();
                    alert("Server down")
                }
            })
        } else {
            alert("please select ID Card image")
        }
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profileImg').attr('src', e.target.result)
            }
            imageFile = input.files[0]
            let modal = document.getElementById("myModal")
            reader.readAsDataURL(input.files[0]);

            compressImg();

            parseTextHandle();

        }
    }

    function compressImg() {
        const compressor = new Compressor(imageFile, {
            quality: 0.85,
            success(result) {
                imageFile = result
            }
        });
    }

    function resetData() {

        $("#id").val("");
        $("#firstname").val("");
        $("#lastname").val("");
        $("#formFile").val("");
        $("#dateOfBirth").val("");
        $("#imageCrop").attr('src', "./icon/id_pic.svg");
        $('#profileImg').attr('src', "./icon/id-card.svg");
    }
</script>

</html>
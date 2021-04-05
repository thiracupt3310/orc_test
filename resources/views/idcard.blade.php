<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Demo IdCard</title>
</head>

<body>
    <h1> Demo</h1>
    <div class="row">
        <div class="col">

            <!-- <div class="mb-3"> -->
            <!-- <label id="labelImage" for="profileImg" class="form-label"></label> -->
            <img id="profileImg" style="width: 200px;height: auto">


            <input class="form-control" type="file" id="formFile" onchange="readURL(this)">
            <button type="button" class="btn btn-outline-primary" onclick="parseTextHandle()">Parse Text</button>

            <!-- </div> -->
        </div>
        <div class="col">
            <img id="imageCrop" /><br>

            <label for="id">ID Card Number</label>
            <input class="form-control" type="text" placeholder="ID Card Number" aria-label="default input example" id="id">

            <label for="firstname">Firstname</label>
            <input class="form-control" type="text" placeholder="Firstname " aria-label="default input example" id="firstname">

            <label for="lastname">Lastname</label>
            <input class="form-control" type="text" placeholder="Lastname" aria-label="default input example" id="lastname">

            <label for="dateOfBirth">Date Of Birth</label>
            <input class="form-control" type="text" placeholder="Date of Birth" aria-label="default input example" id="dateOfBirth">
        </div>
    </div>
</body>
<script>
    let imageFile

    function parseTextHandle() {
        $("#id").val("");
        $("#firstname").val("");
        $("#lastname").val("");
        $("#dateOfBirth").val("");
        $("#imageCrop").attr('src', "");

        if (imageFile != undefined) {
            let fd = new FormData();

            fd.append('image', imageFile);
            fd.append('_token', "{{ csrf_token() }}")

            // console.log(fd)
            // for (var p of fd) {
            //     console.log(p);
            // }
            $.ajax({ //create an ajax request to display.php
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

                    console.log(response)
                    // if ()
                },
                error: function(e){
                    console.log(e)
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
            reader.readAsDataURL(input.files[0]);
            imageFile = input.files[0]

            // console.log(imageFile)
        }
    }
</script>

</html>
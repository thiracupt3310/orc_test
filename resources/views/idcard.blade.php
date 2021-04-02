<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Demo IdCard</title>
</head>

<body>
    <h1 > Demo</h1>
    <form action="{url{'/idcard'}}" method="POST">
        <div class="mb-3">
            <label for="formFile" class="form-label">image ID card</label>
            <input class="form-control" type="file" id="formFile">
        </div>
    </form>
    <form>
        <button type="button" class="btn btn-outline-primary">Parse Text</button>
    </form>
    <input class="form-control" type="text" placeholder="Id card" aria-label="default input example" id =" id">
    <input class="form-control" type="text" placeholder="Firstname " aria-label="default input example" id = "firstname">
    <input class="form-control" type="text" placeholder="Lastname" aria-label="default input example"id = "lastname">
    <input class="form-control" type="text" placeholder="Date of Birth" aria-label="default input example" id = "dataOfBirth">
</body>

</html>
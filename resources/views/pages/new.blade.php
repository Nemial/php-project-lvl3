<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Page Analyzer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
        #background {
            background-color: #273746;
            height: 300px;
        }

    </style>
</head>
<body>
<div class="container">
    @include('flash::message')
</div>
<div id="background" class="container-fluid">
    <a style="color: white; font-size: 26px;" href="{{ route("pages") }}">Domains</a>
    <div class="container">
        <h1 align="center" style="color: white; padding: 40px 0 0px 0">Page Analyzer</h1>
        <form method="POST" action="/pages">
            @csrf
            <div class="container" align="center" style="padding: 110px 0 0 0">
                <input type="text" name="page">
                <input type="submit" class="btn btn-primary" value="CHECK">
            </div>
        </form>
    </div>

</div>

</body>
</html>

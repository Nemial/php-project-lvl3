<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Page Analyzer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body class="d-flex flex-column">
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route("/") }}">Analyzer</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("domains") }}">Domains</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="container">
    @include('flash::message')
</div>

<main class="flex-grow-1 text-white">
    <div class="jumbotron jumbotron-fluid bg-dark">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto">
                    <h1 class="display-3">Page Analyzer</h1>
                    <p class="lead">Check web pages for free</p>
                    <form method="POST" action="{{ route("domains") }}" class="d-flex justify-content-center">
                        @csrf
                        <input type="text" name="domain[name]" value="" class="form-control form-control-lg"
                               placeholder="https://www.example.com">
                        <input type="submit" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase" value="Check">
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="border-top py-3 mt-5">
    <div class="container-lg">
        <div class="text-center">
            created by
            <a href="https://github.com/Nemial" target="_blank">Nemial</a>
        </div>
    </div>
</footer>
</body>
</html>

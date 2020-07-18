<!DOCTYPE html >
<html>
<head>
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

<main class="flex-grow-1">
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Site: {{ $domain->name }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <thead class="thead-dark text-uppercase">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $domain->id }}</td>
                    <td>{{ $domain->name }}</td>
                    <td>{{ $domain->created_at }}</td>
                    <td>{{ $domain->updated_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <h2 class="mt-5 mb-3">Checks</h2>
        <form method="POST" action="{{ route("domains.check", ['id' => $domain->id]) }}">
            @csrf
            <input type="submit" class="btn btn-primary mb-3" value="Run check">
        </form>
        <table class="table table-bordered table-hover text-nowrap">
            <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Status Code</th>
                <th>h1</th>
                <th>Keywords</th>
                <th>Description</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($checks as $check)
                <tr>
                    <td>{{ $check->id }}</td>
                    <td>{{ $check->status_code }}</td>
                    <td>{{ $check->h1 }}</td>
                    <td>{{ $check->keywords }}</td>
                    <td>{{ $check->description }}</td>
                    <td>{{ $check->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
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

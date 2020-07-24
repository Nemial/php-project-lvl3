@extends('layouts.page')

@section('title', 'Page Analyzer')

@section('nav-link')
    @parent
    <a class="nav-link" href="{{ route("domains") }}">Domains</a>
@endsection

@section('flash')

@section('main')
    @parent
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
@endsection

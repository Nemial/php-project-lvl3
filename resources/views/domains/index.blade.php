@extends('layouts.page')
@section('title', 'Page Analyzer')
@section('nav-link')
    @parent
    <a class="nav-link active" href="{{ route("domains") }}">Domains</a>
@endsection

@section('main')
    <main class="flex-grow-1">
        <div class="container-lg">
            <h1 class="mt-5 mb-3">Domains</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-nowrap">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Last check</th>
                        <th>Status Code</th>
                    </tr>
                    @foreach($domains as $domain)
                        <tr>
                            <td>{{ $domain->id }}</td>
                            <td><a href="{{ route('domains.show', ['id' => $domain->id]) }}">{{ $domain->name }}</a></td>
                            <td>{{ $domain->created_at }}</td>
                            <td>{{ $domain->status_code }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </main>
@endsection

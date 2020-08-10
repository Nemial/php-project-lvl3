@extends('layouts.page')
@section('title', 'Page Analyzer')

@section('main')
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
                        <td>
                            <a href="{{ route('domains.show', ['id' => $domain->id]) }}">{{ $domain->name }}</a>
                        </td>
                                <td>{{ $checks[$domain->id]->created_at ?? '' }}</td>
                                <td>{{ $checks[$domain->id]->status_code ?? '' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

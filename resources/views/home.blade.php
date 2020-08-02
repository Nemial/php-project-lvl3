@extends('layouts.page')
@section('title', 'Page Analyzer')

@section('main')
        <div class="jumbotron jumbotron-fluid bg-dark text-white">
            <div class="container-xl">
                <div class="row">
                    <div class="col-12 col-md-10 col-lg-8 mx-auto">
                        <h1 class="display-3">Page Analyzer</h1>
                        <p class="lead">Check web pages for free</p>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <form method="POST" action="{{ route("domains") }}" class="d-flex justify-content-center">
                            @csrf
                            <input type="text" name="domain[name]" value="{{ session()->pull('nameUrl') ?? '' }}"
                                   class="form-control form-control-lg"
                                   placeholder="https://www.example.com">
                            <input type="submit" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase" value="Check">
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@extends('layout.master')

@section('title', 'Gmedia.Net - Manage Page')

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Login Page</h1>
            <div class="container mt-5">
                <h2>Change Hotspot Login Page</h2>

                @if(session('success'))
                    <div class="alert alert-success mt-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mt-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row mt-4">
                    <div class="col-md-6">
                        <form action="{{ route('file.transfer.uploadpage1') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-primary mb-3">Default Login Page</button>
                        </form>
                        <img src="{{ asset('assets/page1.jpg') }}" alt="Page 1 Preview" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('file.transfer.uploadpage2') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-primary mb-3">Login Page 2</button>
                        </form>
                        <img src="{{ asset('assets/page2.jpg') }}" alt="Page 2 Preview" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layout.footer')
</div>
@endsection

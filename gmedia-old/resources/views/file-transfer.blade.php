@extends('layout.master')

@section('title', 'Gmedia.Net - Manage Page')

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Login Page</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Manage Page</li>
            </ol>
            <div class="container mt-5">
                <h1>Upload File to MikroTik</h1>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('file.transfer.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="file">File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="destination">Destination</label>
                        <input type="text" name="destination" class="form-control" placeholder="e.g. /directory/yourfile.html" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </main>
    @include('layout.footer')
</div>
@endsection

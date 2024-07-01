@extends('layout.master')

@section('title', 'Gmedia.Net - Manage Page')

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Hotspot Login Page</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Manage File</li>
            </ol>
            <div class="container mt-5">
                <h1>All template files must be in one folder</h1>

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

                <form action="{{ route('upload.uploadManual') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="file">File</label>
                        <input type="file" name="files[]" class="form-control" multiple webkitdirectory directory>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </main>
    @include('layout.footer')
</div>
@endsection

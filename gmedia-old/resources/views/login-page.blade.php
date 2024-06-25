@extends('layout.master')
@section('title', 'Gmedia.Net - Login Page')
@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Login Page</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Login Page</li>
            </ol>

            <!-- Display success message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form for editing the login page -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Edit Login Page
                </div>
                <div class="card-body">
                    <form action="{{ route('login-page.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $loginPage->name ?? '' }}" required placeholder="Name">
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="content" name="content" style="height:300px;" required placeholder="Content">{{ $loginPage->content ?? '' }}</textarea>
                            <label for="content">Content</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @include('layout.footer')
</div>
@endsection

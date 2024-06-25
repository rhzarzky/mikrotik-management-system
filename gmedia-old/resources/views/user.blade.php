@extends('layout.supermaster')
 @section('title','Gmedia.Net - User')
 @section('content')

<div id="layoutSidenav_content">
 	<main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">User</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adduser">
                            <i class="fa-solid fa-user-plus"></i> &nbsp; User
                        </button>
                    </div>
                </div>

        <!-- Modal add-->

                <div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                <!--  Form add -->
                        <form action="{{ route('adduser.post') }}" method="POST" >
                            @csrf 
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Masukkan email" required >
                                <label class="form-label">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="name" placeholder="Masukkan nama" required >
                                <label class="form-label">Name</label>
                            </div>
                            <div class="form-floating mb-3"> 
                                <input type="text" class="form-control" name="password" placeholder="Masukkan password" required>
                                <label class="form-label">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                 <select class="form-control" name="level" placeholder="level" required>
                                    <option disabled selected required>--Pilih Role--</option>
                                    <option value="admin"> Admin </option>   
                                    <option value="user"> User </option>
                                </select>
                                <label class="form-label">Role</label>
                            </div>
                        </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      </div>
                    </form>
                    <!-- Akhir Form -->
                    </div>
                  </div>
                </div>
           <!--  close modal add-->

               <!--  Data User -->

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data User
                    </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
	                            <thead>
								    <tr align="center">
								        <th>No</th>
                                        <th>Name</th>
								        <th>Email</th>
                                        <th>Role</th>
								        <th>Action</th>
								    </tr>
								</thead>
							    <tbody>
                                    @foreach ($datausers as $no => $item)
                                        <tr>
                                            <div hidden> {{ $item->id }} </div>
                                            <td> {{ $no + 1 }} </td> 
                                            <td> {{ $item->name}} </td>  
                                            <td> {{ $item->email }} </td>                     
                                            <td> {{ $item->level}} </td>
                                            <td>
                                                <div class="form-button-action">
                                        <!-- button edit -->
                                                <a class="btn btn-link btn-lg" data-bs-toggle="modal" data-bs-target="#edit{{$item->id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                        <!--  button hapus -->
                                                <a href="{{route('deleteUser', $item->id)}}" class="btn btn-link btn-lg" id="deleteuser" data-nama="{{$item->username}}">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>

                        <!-- Modal edit-->

                        <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                            <!--  Form Edit -->

                              <div class="modal-body">
                                <form action="{{ route('user.edit', $item->id) }}" method="POST" >
                                @csrf 
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" name="email" value="{{ $item -> email }}" placeholder="Masukkan email" required>
                                        <label class="form-label" for="user">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="name" value="{{ $item -> name }}" placeholder="Masukkan nama" required >
                                        <label class="form-label">Name</label>
                                    </div>
                                    <div class="form-floating mb-3"> 
                                        <select class="form-control" name="level" placeholder="level" required>
                                            <option disabled selected required>--Pilih Role--</option>
                                                @if ( $item -> level == "admin")
                                                    <option value="admin" selected>Admin</option>
                                                    <option value="user">User</option>
                                                @elseif($item -> level == "user")
                                                    <option value="admin">Admin</option>
                                                    <option value="user" selected>User</option>
                                                @endif
                                        </select>
                                        <label class="form-label">Role</label>
                                    </div>
                                </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Ubah</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                            </form>
                            <!-- Akhir Form -->

                            </div>
                          </div>
                        </div>
                   <!--  close modal edit --> 

                                    @endforeach
                                </tbody>
                            </table>
	                     </div>
	                </div>

	              <!--   Akhir Data Voucher -->
	              
	        	</div>
	    	</main>
	    @include('layout.footer')
	</div>
<!-- 
 <script src="https://cdn.jsdelivr.net/npm/laravel-echo@^1.11.4/dist/echo.min.js"></script>
<script>
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });
</script> -->
 @endsection


 
 @extends('layout.master')
 @section('title','Gmedia.Net - File Mikrotik')
 @section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">File Mikrotik</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">login.html</li>
                </ol>

               <!--  Data profile -->

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Profile
                    </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($file as $no => $data)
                                    <tr align="center">
                                        <div hidden>{{ $id = str_replace('*', '', $data['.id']) }}</div>
                                        <td>{{ $no }}</td>
                                        <td>{{ $data['name'] }}</td>
                                        <td>{{ $data['type'] }}</td>
                                        
                                        <td>
                                            <div class="form-button-action">
                                                <a  class="btn btn-link btn-lg" data-original-title="Edit Task" data-bs-toggle="modal" data-bs-target="#edit{{$id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                               <!--  button hapus -->
                                                <a href="{{ route('deletefile', $id) }}" class="btn btn-link btn-lg" 
                                                    id="deletefile" data-nama="{{$data['name']}}">
                                                    <i class="fa fa-times"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>


                           <!-- Modal edit-->
                            <div class="modal fade" id="edit{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit File</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!--  Form edit -->
                                            <form action="{{ route('editfile.post') }}" method="POST" >
                                                @csrf
                                                <div class="form-floating mb-3">
                                                    <input type="hidden" value="<?= $data['.id'] ?>" name="id">
                                                    <!-- Ubah input menjadi textarea -->
                                                    <textarea class="form-control" name="contents" rows="5" style="height:400px; overflow-y: auto;" required placeholder="Contents">{{ $data['contents'] ?? '' }}</textarea>
                                                    <label class="form-label">Contents</label>
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
                            <!--  close modal edit-->



                                    @endforeach
                                </tbody>
                            </table>
                         </div>
                    </div>

                  <!--   Akhir Data profile -->
                  
                </div>
            </main>
        @include('layout.footer')
    </div>
 @endsection
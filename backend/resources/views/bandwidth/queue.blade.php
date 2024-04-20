@extends('layouts.master')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">@yield('title')</h2>
                        <h5 class="text-white op-7 mb-2">Total Simple Queue : {{ $totalqueue }}</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <!-- <h4 class="card-title">Add Row</h4> -->
                            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
                                <i class="fa fa-plus"></i>
                                Add Queue
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Modal Add-->
                        <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header no-bd">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                New Simple Queue
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- <p class="small">Create a new row using this form, make sure you fill them all</p> -->
                                        <form action="{{ route('bandwidth.add') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input name="name" type="text" id="name" class="form-control" placeholder="Name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Target</label>
                                                        <input name="target" type="text" id="target" class="form-control" placeholder="Target" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label> Max Upload/Max Download (bits/s)</label>
                                                        <input name="max-limit" id="max-limit" type="text" class="form-control" placeholder="Upload/Download">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Target Download</label>
                                                        <input name="download" id="download" class="form-control" placeholder="Max Download">
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Comment</label>
                                                        <input name="comment" id="comment" type="text" class="form-control" placeholder="Comment">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer no-bd">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Target</th>
                                    <th>Max Upload/Max Download (bits/s)</th>
                                    <th>Status</th>
                                    <th>Comment</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Target</th>
                                    <th>Max Upload/Max Download (bits/s)</th>
                                    <th>Status</th>
                                    <th>Comment</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($queue as $no => $item)
                                <tr>
                                    <div hidden>{{ $id = str_replace('*', '', $item['.id']) }}</div>
                                    <td>{{ $no+1 }} </td>
                                    <td>{{ $item['name'] ?? '' }} </td>
                                    <td>{{ $item['target']  ?? '' }} </td>
                                    <td>{{ $item['max-limit']  ?? '' }} </td>
                                    <td>
                                        @if ($item['disabled'] == "true")
                                        Disable
                                        @else
                                        Enable
                                        @endif
                                    </td>
                                    <td>{{ $item['comment'] ?? '' }} </td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="" class="btn btn-link btn-primary btn-lg" data-toggle="tooltip" data-original-title="Edit Task">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="" type="button" data-toggle="tooltip" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Apakah anda yakin menghapus queue {{ $item['name'] }} ?')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


@endsection
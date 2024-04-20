@extends('layouts.master')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">@yield('title')</h2>
                        <h5 class="text-white op-7 mb-2">Total User Hotspot : {{ $totalhotspotuser }}</h5>
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
                                Add User Hotspot
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
                                                New</span>
                                            <span class="fw-light">
                                                User Hotspot
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- <p class="small">Create a new row using this form, make sure you fill them all</p> -->
                                        <form action="{{ route('hotspot.add') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>User</label>
                                                        <input name="user" type="text" class="form-control @error ('user') is-invalid @enderror" placeholder="User">
                                                        @error ('user')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Password</label>
                                                        <input name="password" type="text" class="form-control @error ('password') is-invalid @enderror" placeholder="Password">
                                                        @error ('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Server</label>
                                                        <select name="server" class="form-control" placeholder="Server">
                                                            <option disabled selected>Pilih</option>
                                                            @foreach ($server as $data)
                                                            <option>{{ $data['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Profile</label>
                                                        <select name="profile" class="form-control" placeholder="Profile">
                                                            <option disabled selected>Pilih</option>
                                                            @foreach ($profile as $data)
                                                            <option>{{ $data['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Time Limit</label>
                                                        <input name="limit-uptime" type="text" class="form-control" placeholder="Time Limit">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Comment</label>
                                                        <input name="comment" type="text" class="form-control" placeholder="Comment">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer no-bd">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
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
                                <th>Username</th>
                                <th>Password</th>
                                <th>Profile</th>
                                <th>Uptime</th>
                                <th>Bytes In</th>
                                <th>Bytes Out</th>
                                <th>Status</th>
                                <th>Comment</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Profile</th>
                                <th>Uptime</th>
                                <th>Bytes In</th>
                                <th>Bytes Out</th>
                                <th>Status</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($hotspotuser as $no => $item)
                            <tr>
                                <!-- <div hidden>{{ $id = str_replace('*', '', $item['.id']) }}</div>
                                    <td>{{ $no+1 }} </td>
                                    <td>{{ $item['name'] ?? '' }} </td>
                                    <td>{{ $item['password']  ?? '' }} </td>
                                    <td>{{ $item['service']  ?? '' }} </td>
                                    <td>{{ $item['local-address']  ?? '' }} </td>
                                    <td>{{ $item['remote-address']  ?? '' }} </td>
                                    <td>
                                        @if ($item['disabled'] == "true")
                                        Disable
                                        @else
                                        Enable
                                        @endif
                                    </td>
                                    <td>{{ $item['comment'] ?? '' }} </td> -->
                                <div hidden>{{ $id = str_replace('*', '', $item['.id']) }}</div>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $item['name'] ?? '' }}</td>
                                <td>{{ $item['password'] ?? '' }}</td>
                                <td>{{ $item['profile'] ?? '' }}</td>
                                <td>{{ $item['uptime'] ?? '' }}</td>
                                <td>{{ formatBytes($item['bytes-in'],) }}</td>
                                <td>{{ formatBytes($item['bytes-out'],) }}</td>
                                <td>
                                    @if ($item['disabled'] == "true" )
                                    Disable
                                    @else
                                    Enable
                                    @endif

                                </td>
                                <td>{{ $item['comment'] }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="{{ route('pppoe.edit', $id) }}" class="btn btn-link btn-primary btn-lg" data-toggle="tooltip" data-original-title="Edit Task">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="{{ route('pppoe.delete', $id) }}" type="button" data-toggle="tooltip" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Apakah anda yakin menghapus secret {{ $item['name'] }} ?')">
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

<?php function formatBytes($bytes, $decimal = null)
{
    $satuan = ['Bytes', 'Kb', 'Mb', 'Gb', 'Tb'];
    $i = 0;
    while ($bytes > 1024) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, $decimal) . '-' . $satuan[$i];
}
?>

@endsection
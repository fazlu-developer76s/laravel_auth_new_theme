@if(@$get_role)
    @php
        $action = route('role.update');
        $method = "post";
    @endphp
@else
    @php
        $action = route('role.create');
        $method = "post";
    @endphp
@endif
@extends('include.app')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <!-- PAGE-HEADER -->
            <div class="page-header">
                <h1 class="page-title">Role Management</h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Role</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Role List</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE-HEADER END -->
            <!-- Row -->
            <div class="row row-sm">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Role</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ $action }}" method="{{ $method }}">
                            @csrf
                            <div class="row">
                                @if(@$get_role->id)
                                <input type="hidden" name="hidden_id" value="{{ @$get_role->id }}">
                                @endif
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Title <span class="text-red">*</span></label>
                                        <input type="text" name="title" class="form-control  @error('title') is-invalid state-invalid @enderror" value="{{ (@$get_role) ? @$get_role->title : old('title') ; }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status <span class="text-red">*</span></label>
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" name="status">
                                            <option value="1" @if(@$get_role) {{ (@$get_role->status == 1) ? 'selected' : '' ; }} @else  {{ old('status') == 1 ? 'selected' : '' }} @endif>Active</option>
                                            <option value="2" @if(@$get_role) {{ (@$get_role->status == 2) ? 'selected' : '' ; }} @else  {{ old('status') == 2 ? 'selected' : '' }} @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-4 mb-0">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Role List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Title</th>
                                            <th class="border-bottom-0">Created At</th>
                                            <th class="border-bottom-0">Status</th>
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($allrole))
                                            @foreach ($allrole as $key => $role )
                                        <tr>
                                            <td>{{ ucwords($role->title) }}</td>
                                            <td>{{ \Carbon\Carbon::parse(@$role->created_at)->format('d F Y h:i A') ?? 'N/A' }}</td>
                                            <td>
                                              <div class="form-group m-0">
                                                <label class="custom-switch form-switch">
                                                    <input id="flexSwitchCheckDefault{{ $role->id }}" type="checkbox" name="custom-switch-radio1" class="custom-switch-input" {{ ($role->status == 1) ? 'checked' : '' ; }} onchange="Changestatus('tbl_roles','{{ $role->id }}');">
                                                    <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                </label>
                                              </div>
                                            </td>
                                            <td>
                                                <div class="g-2">
                                                    <a href="{{ route('role.edit',$role->id) }}" class="btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>
                                                    <form action="{{ route('role.delete', $role->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete" onclick="return confirm('Are you sure you want to delete this route?');">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- CONTAINER CLOSED -->
    </div>
</div>
@endsection

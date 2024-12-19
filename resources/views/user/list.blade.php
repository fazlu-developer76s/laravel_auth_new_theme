@extends('include.app')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">User Management</h1>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User List</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered text-nowrap border-bottom">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">Name</th>
                                        <th class="border-bottom-0">Email</th>
                                        <th class="border-bottom-0">Mobile</th>
                                        <th class="border-bottom-0">Created At</th>
                                        <th class="border-bottom-0">Status</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($users))
                                        @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ ucwords($user->name) }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td>{{ \Carbon\Carbon::parse(@$user->created_at)->format('d F Y h:i A') ?? 'N/A' }}</td>
                                            <td>
                                                <div class="form-group">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input id="flexSwitchCheckDefault{{ $user->id }}" type="checkbox" name="custom-switch-radio1" class="custom-switch-input" {{ ($user->status == 1) ? 'checked' : '' ; }} onchange="Changestatus('users','{{ $user->id }}');">
                                                        <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="g-2">
                                                    <a href="{{ route('user.edit', $user->id) }}" class="btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                        <span class="fe fe-edit fs-14"></span>
                                                    </a>
                                                    <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
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
    </div>
</div>
@endsection

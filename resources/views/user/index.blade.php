@extends('include.app')
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <h1 class="page-title">User Management</h1>
            </div>
            <div class="row row-sm">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($user) ? 'Edit User' : 'Add User' }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($user) ? route('user.update') : route('user.create') }}" method="POST">
                                @csrf
                                @if(isset($user))
                                    <input type="hidden" name="hidden_id" value="{{ $user->id }}">
                                @endif
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($user) ? $user->name : old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ isset($user) ? $user->email : old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Mobile</label>
                                    <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ isset($user) ? $user->mobile : old('mobile') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    <small class="text-muted">Leave blank to keep the current password.</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ isset($user) && $user->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ isset($user) && $user->status == 2 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4 mb-0">{{ isset($user) ? 'Update' : 'Submit' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

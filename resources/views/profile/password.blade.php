@extends('layouts.app')

@push('before')
@endpush

@push('after')
@endpush

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ $message }}</strong>
        </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <div class="float-left">Profile > Password</div>
            <div class="float-right"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" class="form-control form-control-lg @error('current_password') is-invalid @enderror" name="current_password">
                    @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control form-control-lg @error('new_password') is-invalid @enderror" name="new_password">
                    @error('new_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control form-control-lg @error('confirm_new_password') is-invalid @enderror" name="confirm_new_password">
                    @error('confirm_new_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <br><hr>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
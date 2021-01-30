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
            <div class="float-left">Setting > Register & Login</div>
            <div class="float-right"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('setting.relog') }}">
                @csrf
                @include('setting.form')
                <br><hr>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
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
            <div class="float-left">Profile > Avatar</div>
            <div class="float-right"></div>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <img src="{{ $image }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                </div>
                <div class="col-md-9">
                    <form enctype="multipart/form-data" action="{{ route('avatar.show') }}" method="POST">
                        <input type="file" class="form-control-file @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                        @error('avatar')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div style="padding-top:20px"><input type="submit" class="pull-right btn btn-primary"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
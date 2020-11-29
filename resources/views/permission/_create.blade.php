@extends('layouts.app')

@push('before')
@endpush

@push('after')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">Create Permission</div>
        <div class="card-body">
            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="textfield" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Create</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            </form>
        </div>
    </div>
@endsection
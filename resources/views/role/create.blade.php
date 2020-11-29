@extends('layouts.app')

@push('before')
@endpush

@push('after')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">Create Role</div>
        <div class="card-body">
            <form method="POST" action="{{ route('role.store') }}">
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

                <br>
                <div class="form-group">
                    <h5><b>Assign Permissions</b></h5>
                    @foreach ($permissions as $title => $records)
                        <br><h5>{{ $title }}</h5>
                        @foreach ($records as $name => $label)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $name }}">
                                <label class="form-check-label"> {{ $label }}</label>
                            </div>
                        @endforeach
                        <br>
                    @endforeach
                    @error('permission')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <br><hr>
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
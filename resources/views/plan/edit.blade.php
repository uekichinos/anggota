@extends('layouts.app')

@push('before')
@endpush

@push('after')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">Edit Plan</div>
        <div class="card-body">
            <form method="POST" action="{{ route('plan.update', $plan->id) }}">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="textfield" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ $plan->name }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control form-control-lg @error('desc') is-invalid @enderror" name="desc">{{ $plan->desc }}</textarea>
                    @error('desc')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" min="0" step=".01" class="form-control form-control-lg @error('price') is-invalid @enderror" value="{{ $plan->price }}" autofocus>
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <br><hr>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('plan.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
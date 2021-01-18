@extends('layouts.noapp')

@push('before')
@endpush

@push('after')
@endpush

@section('content')
<div class="card">
        <div class="card-header">Acceptance</div>
        <div class="card-body">
            {!! $copywriting !!}
            <form method="POST" action="{{ route('sign.index') }}">
                @csrf
                <center><button type="submit" class="btn btn-primary">I Accept</button></center>
            </form>
        </div>
    </div>
@endsection
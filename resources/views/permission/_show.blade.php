@extends('layouts.app')

@push('before')
@endpush

@push('after')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">View Detail</div>
        <div class="card-body">
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Name</div>
                <div style="font-size:16px;">{{ $data->name }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Created On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($data->created_at)) }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Updated On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($data->updated_at)) }}</div>
            </div>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
@endsection
@extends('layouts.app')

@push('before')
    <link rel="stylesheet" href="{{ asset('icon/font/css/open-iconic-bootstrap.css') }}">
@endpush

@push('after')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">View Detail</div>
        <div class="card-body">
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Name</div>
                <div style="font-size:16px;">{{ $plan->name }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Description</div>
                <div style="font-size:16px;">{{ $plan->desc }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Price</div>
                <div style="font-size:16px;">{{ $plan->price }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Created On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($plan->created_at)) }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Updated On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($plan->updated_at)) }}</div>
            </div>
            <br><hr>
            <a href="{{ route('plan.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
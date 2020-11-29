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
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Description</div>
                <div style="font-size:16px;">{{ $activity->description }} by {{ $activity->causer_name }}</div>
            </div>
            @if(isset($activity->properties['old']))
                <div class="form-group">
                    <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Before Update</div>
                    <div style="font-size:16px;">                  
                        @foreach ($activity->properties['old'] as $key => $value)
                            <p>
                                <u>{{ $key }}</u><br>
                                @if($activity->subject_type == 'App\Avatar' && $key == 'filedata') 
                                    <img src="data:;base64,{{ $value }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px; float: inherit;">
                                @else
                                    {{ $value }}
                                @endif
                            </p>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">After Update</div>
                <div style="font-size:16px;">
                    @foreach ($activity->properties['attributes'] as $key => $value)
                        <p>
                            <u>{{ $key }}</u><br>
                            @if($activity->subject_type == 'App\Avatar' && $key == 'filedata') 
                                <img src="data:;base64,{{ $value }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px; float: inherit;">
                            @else
                                {{ $value }}
                            @endif
                        </p>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Created On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($activity->created_at)) }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Updated On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($activity->updated_at)) }}</div>
            </div>

            <a href="{{ route('activitylog.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
@endsection
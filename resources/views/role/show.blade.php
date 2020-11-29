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
                <div style="font-size:16px;">{{ $role->name }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Permissions</div>
                @foreach ($permissions as $title => $records)
                    <div style="width:100px; float:left;">{{ $title }}</div>
                    @foreach ($records as $name => $label)
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <?php
                                if(in_array($name, $rolepermissions)) {
                                    echo '<span style="color:green" class="oi oi-check"></span>';
                                }
                                else {
                                    echo '<span style="color:red" class="oi oi-x"></span>';
                                }
                                ?>
                                {{ $label }}
                            </label>
                        </div>
                    @endforeach
                    <br>
                @endforeach
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Created On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($role->created_at)) }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="border-bottom:1px solid #d5d6d4; font-weight:bold;">Updated On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($role->updated_at)) }}</div>
            </div>
            <br><hr>
            <a href="{{ route('role.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
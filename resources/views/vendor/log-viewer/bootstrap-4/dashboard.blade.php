@extends('layouts.app')

@push('before')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ asset('css/logviewer.css') }}" rel="stylesheet">
@endpush

@push('after')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="float-left">Audit > Log Viewer > Dashboard</div>
            <div class="float-right"></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <a href="{{ route('log-viewer::logs.list') }}" class="btn btn-primary btn-sm">Logs</a>
                </div>
                <br><br>
                <div class="col-md-12 col-lg-12">
                    <div class="row">
                        @foreach($percents as $level => $item)
                            <div class="col-sm-6 col-md-12 col-lg-4 mb-3">
                                <div class="box level-{{ $level }} {{ $item['count'] === 0 ? 'empty' : '' }}">
                                    <div class="box-icon">
                                        {!! log_styler()->icon($level) !!}
                                    </div>
                                    <div class="box-content">
                                        <span class="box-text">{{ $item['name'] }}</span>
                                        <span class="box-number">
                                            {{ $item['count'] }} @lang('entries') - {!! $item['percent'] !!} %
                                        </span>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar" style="width: {{ $item['percent'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

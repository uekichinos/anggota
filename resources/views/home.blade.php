@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
    
            <div class="row">
                @if($ismember === true)
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Acceptance Sign</h5>
                            <p class="card-text">You accept the agreement at {{ date("d M Y, H:ia", strtotime($user->accept_at)) }}. Click here to <a href="{{ route('accept.download') }}" target="_blank">download</a>.</p>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

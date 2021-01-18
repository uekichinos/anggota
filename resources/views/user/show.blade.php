@extends('layouts.app')

@push('before')
@endpush

@push('after')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">View Detail</div>
        <div class="card-body">
            <h5>Account</h5>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Username</div>
                <div style="font-size:16px;">{{ $user->username }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Role</div>
                <div style="font-size:16px;">{{ ucfirst($user->role) }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Last Online</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($user->last_online_at)) }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Accept On</div>
                <div style="font-size:16px;">{{ (empty($user->accept_at) ? "-" : date('d M Y, H:i', strtotime($user->accept_at))) }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Created On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($user->created_at)) }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Updated On</div>
                <div style="font-size:16px;">{{ date('d M Y, H:i', strtotime($user->updated_at)) }}</div>
            </div>
            <hr>
            <h5>Member Details</h5>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Name</div>
                <div style="font-size:16px;">{{ $user->name }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Member No</div>
                <div style="font-size:16px;">{{ $user->memberno }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Email address</div>
                <div style="font-size:16px;">{{ $user->email }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">NRIC</div>
                <div style="font-size:16px;">{{ $user->nric }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Contact No</div>
                <div style="font-size:16px;">{{ $user->contactno }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Address</div>
                <div style="font-size:16px;">{{ $user->address }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Date of Birth</div>
                <div style="font-size:16px;">{{ $user->dob }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Bank Name</div>
                <div style="font-size:16px;">{{ $user->bankname }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Account No</div>
                <div style="font-size:16px;">{{ $user->bankaccno }}</div>
            </div>
            <hr>
            <h5>Subscribe Plan</h5>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Plans</div>
                <div style="font-size:16px;">
                    @php
                        $planArr = explode("|", $user->plan);
                        foreach ($plans as $key => $plan) {
                            if(in_array($plan->id, $planArr)) {
                                echo $plan->name.'<br>';
                            }
                        }
                    @endphp
                </div>
            </div>
            <hr>
            <h5>Next of Kin Details</h5>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Name</div>
                <div style="font-size:16px;">{{ $user->n_name }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">NRIC</div>
                <div style="font-size:16px;">{{ $user->n_nric }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Contact No</div>
                <div style="font-size:16px;">{{ $user->n_contactno }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Bank Name</div>
                <div style="font-size:16px;">{{ $user->n_bankname }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Account No</div>
                <div style="font-size:16px;">{{ $user->n_bankaccno }}</div>
            </div>
            <hr>
            <h5>Introducer Details</h5>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Name</div>
                <div style="font-size:16px;">{{ ($introducer != NULL ? $introducer->name : '-') }}</div>
            </div>
            <div class="form-group">
                <div class="md-12" style="font-weight:bold;">Contact</div>
                <div style="font-size:16px;">{{ ($introducer != NULL ? $introducer->contactno : '-') }}</div>
            </div>
            <br><hr>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
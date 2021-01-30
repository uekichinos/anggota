@extends('layouts.app')

@push('before')
@endpush

@push('after')
<script type="text/javascript">
function search() {
    var keyword = $('[name="i_memberno"]').val();
    $.ajax({
        type:'POST',
        url:'/backend/searchuser',
        data:'_token=<?php echo csrf_token() ?>&keyword='+keyword,
        success:function(data) {
            var result = data.result;
            if(result.length > 0) {
                var html = '';
                for (var i = 0; i < result.length; i++) {
                    html += '<div>Name: '+result[i].name+'<br>Contact No: '+result[i].contactno+'</div>';
                }
                $('#result').html(html);
            }
        }
    });
}
function cleanup() {
    $('[name="i_memberno"]').val('');
    $('#result').html('');
}
</script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">Edit Participant</div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.update', $user->id) }}">
                @csrf
                <h5>Account</h5>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control form-control-lg" name="role">
                        @foreach ($roles as $key => $role)
                            <option value="{{ $role->name }}" @if (in_array($role->name, $user_roles)) selected @endif >{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <br><hr>
                <h5>Member Details</h5>
                <div class="form-group">
                    <label>Name</label>
                    <input type="textfield" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ $user->name }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Member No</label>
                    <input type="textfield" class="form-control form-control-lg @error('memberno') is-invalid @enderror" name="memberno" value="{{ $user->memberno }}" autofocus>
                    @error('memberno')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>NRIC</label>
                    <input type="number" class="form-control form-control-lg @error('nric') is-invalid @enderror" name="nric" value="{{ $user->nric }}" autofocus>
                    @error('nric')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Contact No</label>
                    <input type="textfield" class="form-control form-control-lg @error('contactno') is-invalid @enderror" name="contactno" value="{{ $user->contactno }}" autofocus>
                    @error('contactno')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control form-control-lg @error('address') is-invalid @enderror" name="address">{{ $user->address }}</textarea>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" class="form-control form-control-lg @error('dob') is-invalid @enderror" name="dob" value="{{ $user->dob }}" autofocus>
                    @error('dob')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Bank Name</label>
                    <input type="textfield" class="form-control form-control-lg @error('bankname') is-invalid @enderror" name="bankname" value="{{ $user->bankname }}" autofocus>
                    @error('bankname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Account No</label>
                    <input type="number" class="form-control form-control-lg @error('bankaccno') is-invalid @enderror" name="bankaccno" value="{{ $user->bankaccno }}" autofocus>
                    @error('bankaccno')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <br><hr>
                <h5>Subscribe Plan</h5>
                <div class="form-group">
                    <label>Plan</label>
                    @php
                        $planArr = explode("|", $user->plan);
                    @endphp
                    @foreach ($plans as $key => $plan)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $plan->id }}" name="plan[]" @if(in_array($plan->id, $planArr)) checked @endif>
                            <label class="form-check-label">
                                {{ $plan->name }}
                            </label>
                        </div>
                    @endforeach
                    @error('plan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <br><hr>
                <h5>Next of Kin Details</h5>
                <div class="form-group">
                    <label>Name</label>
                    <input type="textfield" name="n_name" class="form-control form-control-lg @error('n_name') is-invalid @enderror" value="{{ $user->n_name }}" autofocus>
                    @error('n_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>NRIC</label>
                    <input type="number" class="form-control form-control-lg @error('n_nric') is-invalid @enderror" name="n_nric" value="{{ $user->n_nric }}" autofocus>
                    @error('n_nric')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Contact No</label>
                    <input type="textfield" class="form-control form-control-lg @error('n_contactno') is-invalid @enderror" name="n_contactno" value="{{ $user->n_contactno }}" autofocus>
                    @error('n_contactno')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Bank Name</label>
                    <input type="textfield" class="form-control form-control-lg @error('n_bankname') is-invalid @enderror" name="n_bankname" value="{{ $user->n_bankname }}" autofocus>
                    @error('n_bankname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Account No</label>
                    <input type="number" class="form-control form-control-lg @error('n_bankaccno') is-invalid @enderror" name="n_bankaccno" value="{{ $user->n_bankaccno }}" autofocus>
                    @error('n_bankaccno')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <br><hr>
                <h5>Introducer Details</h5>
                <div class="form-group">
                    <label>Member No</label>
                    <div class="row">
                        <div class="col-9">
                            <input type="textfield" class="form-control form-control-lg @error('i_memberno') is-invalid @enderror" name="i_memberno" value="{{ $user->i_memberno }}" autofocus>
                            <span id="result"></span>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-info" onclick="search()">Verify</button>
                            <button type="button" class="btn btn-info" onclick="cleanup()">Reset</button>
                        </div>
                    </div>
                </div>
                <br><hr>                
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
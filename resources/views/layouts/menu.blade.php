<div class="list-group">
    @if(Session::has('original_user'))
        <a class="list-group-item list-group-item-action" style="color: #761b18; background-color: #f9d6d5; border-color: #f7c6c5;" href="{{ route('impersonate.revert') }}">Revert</a>
    @endif
	<a href="{{ route('home') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'home' ? 'active' : null }}">Dashboard</a>
	@canany('list user')
	    <a href="{{ route('user.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'user' ? 'active' : null }}">Participants</a>
	@endcan
	@canany('list plan')
	    <a href="{{ route('plan.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'plan' ? 'active' : null }}">Plans</a>
	@endcan
	<a href="{{ route('downline.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'downline' ? 'active' : null }}">Downline</a>
	<a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'profile' ? 'active' : null }}">Profile</a>
	@if(Request::segment(2) === 'profile')
		<div class="list-group-item" style="padding:5px; background-color:#f5f3f2;">
			<a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'profile' && Request::segment(3) === 'detail' ? 'active' : null }}">Detail</a>
			<a href="{{ route('password.edit') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'profile' && Request::segment(3) === 'password' ? 'active' : null }}">Password</a>
		</div>
	@endif
</div>

@role('admin')
	<div style="border-bottom:1px solid #bfbfbd; margin:40px 0px 10px 0px;">ADMINISTRATION</div>
	<div class="list-group">
		@canany('list role')
			<a href="{{ route('role.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'access' ? 'active' : null }}">Access</a>
			@if(Request::segment(2) === 'access')
				<div class="list-group-item" style="padding:5px; background-color:#f5f3f2;">				
					@can('list role')
						<a href="{{ route('role.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'access' && Request::segment(3) === 'role' ? 'active' : null }}">Roles</a>
					@endcan
					@can('list permission')
						<a href="{{ route('permission.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'access' && Request::segment(3) === 'permission' ? 'active' : null }}">Permissions</a>
					@endcan
				</div>
			@endif
		@endcan

		@canany('list activitylog')
			<a href="{{ route('activitylog.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'audit' ? 'active' : null }}">Audit</a>
			@if(Request::segment(2) === 'audit')
				<div class="list-group-item" style="padding:5px; background-color:#f5f3f2;">
					@can('list activitylog')
						<a href="{{ route('activitylog.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'audit' && Request::segment(3) === 'activitylog' ? 'active' : null }}">Activity Log</a>
					@endcan
					@can('list logviewer')
						<a href="{{ route('log-viewer::dashboard') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'audit' && Request::segment(3) === 'logviewer' ? 'active' : null }}">Log Viewer</a>
					@endcan
				</div>
			@endif
		@endcan

		@can('edit setting')
			<a href="{{ route('setting.maintenance') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'setting' ? 'active' : null }}">Setting</a>
			@if(Request::segment(2) === 'setting')
				<div class="list-group-item" style="padding:5px; background-color:#f5f3f2;">
					<a href="{{ route('setting.maintenance') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'setting' && Request::segment(3) === 'maintenance' ? 'active' : null }}">Maintenance</a>
					<a href="{{ route('setting.ga') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'setting' && Request::segment(3) === 'ga' ? 'active' : null }}">Google Analytics</a>
					<a href="{{ route('setting.announce') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'setting' && Request::segment(3) === 'announce' ? 'active' : null }}">Annoucement</a>
					<a href="{{ route('setting.password') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'setting' && Request::segment(3) === 'password' ? 'active' : null }}">Password</a>
					<a href="{{ route('setting.header') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'setting' && Request::segment(3) === 'header' ? 'active' : null }}">Header</a>
					<a href="{{ route('setting.relog') }}" class="list-group-item list-group-item-action {{ Request::segment(2) === 'setting' && Request::segment(3) === 'relog' ? 'active' : null }}">Register & Login</a>
				</div>
			@endif
		@endcan
	</div>
	<br><br>
@endrole

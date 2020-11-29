<a class="navbar-brand" href="{{ url('/') }}">
	@php

	$settings = \App\Setting::where('param', 'LIKE', 'header_title')->get();
	if(count($settings) > 0) {
		foreach($settings as $key => $setting) {
			echo $setting->value;
		}
	}

	@endphp
</a>
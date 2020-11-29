@php

$settings = \App\Setting::where('param', 'LIKE', 'announce_%')->get();
if(count($settings) > 0) {
	$config = [];
	foreach($settings as $key => $setting) {
		$config[$setting->param] = $setting->value;
	}

	if(count($config) > 0) {
		$start_dt = date('YmdHis', strtotime($config['announce_start']));
		$end_dt = date('YmdHis', strtotime($config['announce_end']));
		$current_dt = date('YmdHis', strtotime('+8 hour'));
		
		if($config['announce_mode'] == 'yes' && !empty($config['announce_msg']) && ($start_dt <= $current_dt && $end_dt >= $current_dt)) {
			echo '<div class="container">';
			echo '<div class="row justify-content-center p-2">';
			echo '<div class="announce announce-'.$config['announce_mood'].'">'.$config['announce_msg'].'</div>';
			echo '</div>';
			echo '</div>';
		}
	}
}

@endphp
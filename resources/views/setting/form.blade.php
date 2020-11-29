@foreach ($settings as $key => $setting)
    <div class="form-group">
        <label>{{ $setting->label }}</label>
        @if($setting->field == 'number')
            <input type="number" class="form-control form-control-lg @error($setting->param) is-invalid @enderror" name="{{ $setting->param }}" value="{{ $setting->value }}">
        @elseif($setting->field == 'checkbox')
            @php
            $options = explode(',', $setting->options);
            if(count($options) > 0) {
                foreach ($options as $key => $option) {
                    echo '<div class="form-check">
                        <input class="form-check-input" type="radio" name="'.$setting->param.'" value="'.$option.'" '.($setting->value == $option ? 'checked' : '').'>
                        <label class="form-check-label">'.ucfirst($option).'</label>
                    </div>';
                }
            }
            @endphp
        @elseif($setting->field == 'textarea')
            <textarea name="{{ $setting->param }}" class="form-control form-control-lg @error($setting->param) is-invalid @enderror">{{ $setting->value }}</textarea>
        @elseif($setting->field == 'datetime')
            <input type="datetime-local" class="form-control form-control-lg @error($setting->param) is-invalid @enderror" name="{{ $setting->param }}" value="{{ $setting->value }}">
        @else
            <input type="text" class="form-control form-control-lg @error($setting->param) is-invalid @enderror" name="{{ $setting->param }}" value="{{ $setting->value }}">
        @endif

        @if($setting->note)
            <small>{{ $setting->note }}</small>
        @endif

        @error($setting->param)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@endforeach
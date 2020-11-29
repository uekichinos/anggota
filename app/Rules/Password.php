<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Setting;

class Password implements Rule
{

    /**
     * Default parameters
     *
     */
    private $error = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $settings = Setting::where('param', 'LIKE', 'password_%')->get();
        if($settings !== null) {
            foreach ($settings as $key => $setting) {
                if($setting->param == 'password_number' && $setting->value == 'yes' && preg_match('/[0-9]/', $value) === 0) {
                    $this->error = 'The :attribute should contain at least 1 number';
                    return false;
                }
                if($setting->param == 'password_character' && $setting->value == 'yes' && preg_match('/[a-zA-Z]/', $value) === 0) {
                    $this->error = 'The :attribute should contain at least 1 character';
                    return false;
                }
                if($setting->param == 'password_uppercase' && $setting->value == 'yes' && preg_match('/[A-Z]/', $value) === 0) {
                    $this->error = 'The :attribute should contain at least 1 uppercase character';
                    return false;
                }
                if($setting->param == 'password_specialcharacter' && $setting->value == 'yes' && preg_match('/[^a-zA-Z\d]/', $value) === 0) {
                    $this->error = 'The :attribute should contain at least 1 special character';
                    return false;
                }
                if($setting->param == 'password_min' && (strlen($value) < $setting->value)) {
                    $this->error = 'The :attribute must be at least '.$setting->value.' characters';
                    return false;
                }
                if($setting->param == 'password_max' && (strlen($value) > $setting->value)) {
                    $this->error = 'The :attribute may not be greater than '.$setting->value.' characters';
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error;
    }
}

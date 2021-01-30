<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use LogsActivity;

    protected $fillable = ['type', 'label', 'param', 'value', 'field', 'options', 'note'];

    protected static $logAttributes = ['type', 'label', 'param', 'value', 'field', 'options', 'note'];

    protected static $logOnlyDirty = true;

    public static function scopeReLog($query) {

        $return = [];
        $settings = $query->where('param', 'LIKE', 'relog_register')->orWhere('param', 'LIKE', 'relog_reset')->get();
        if (count($settings) > 0) {
            foreach ($settings as $key => $setting) {
                $tmp = explode('_', $setting->param);
                $return[$tmp[1]] = ($setting->value == 'yes' ? true : false);
            }
        }

        return $return;
    }
}

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

}

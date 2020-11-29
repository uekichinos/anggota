<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Avatar extends Model
{
    use LogsActivity;

    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['userid', 'filedata'];

    /**
     * for audit activity.
     */
    protected static $logAttributes = ['userid', 'filedata'];
}

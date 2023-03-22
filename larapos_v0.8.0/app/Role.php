<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Spatie\Activitylog\LogOptions;

class Role extends \Spatie\Permission\Models\Role
{
    public $guarded = [];

    public $incrementing = false;

    protected $hidden = ['pivot'];

    protected $keyType = 'string';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
            if (!$model->guard_name) {
                $model->guard_name = 'web';
            }
        });
    }
}

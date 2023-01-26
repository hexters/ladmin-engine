<?php

namespace Ladmin\Engine;

use Illuminate\Support\Str;

trait UuidGenerator
{

    protected static function bootUuidGenerator()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}

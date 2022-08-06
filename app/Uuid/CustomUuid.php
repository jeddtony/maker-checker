<?php

declare(strict_types=1);

namespace App\Uuid;

use Illuminate\Support\Str;

class CustomUuid
{
    public static function generateUuid(string $className)
    {
        $class = "App\\Models\\" . Str::studly($className);

        $model = new $class;
        $uuid = null;
        // add a do while block
        do {
            $uuid = Str::uuid();
        } while ($model->where('uuid', $uuid)->exists());

        return $uuid;
    }
}
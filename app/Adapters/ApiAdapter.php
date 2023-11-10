<?php

namespace App\Adapters;

use App\Http\Resources\DefaultResource;

class ApiAdapter
{
    public static function toJson($data)
    {
        return DefaultResource::collection($data)->all();
    }
}

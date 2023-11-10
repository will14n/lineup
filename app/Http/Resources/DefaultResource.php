<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultResource extends JsonResource
{
    public static $wrap = 'user';
    public function toArray($request)
    {
        $players = collect($this->resource);
        $playerSkills = $players['skills'];
        unset($players['skills']);
        $players['playerSkills'] = $playerSkills;
        return $players;
    }
}

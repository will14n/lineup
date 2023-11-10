<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PlayerResource extends JsonResource
{
    public static $wrap = '';
    public function toArray($player):array
    {
        if (!isset($this->resource->id)) {
            if (sizeof((array) $this->resource) < 1) {
                return ["message" => "Insufficient number of players for :position: :input"];
            }
            $playerSkills = [];
            foreach ($this->resource as $index => $values) {
                foreach ($values['skills'] as $idx => $skillValues) {
                    $playerSkills[$index]['skill'] = $skillValues['skill'];
                    $playerSkills[$index]['value'] = $skillValues['value'];
                }

                $response[] = [
                    "name" => $values['name'],
                    "position" => $values['position'],
                    "playerSkills" => $playerSkills
                ];
            }
            return $response;
        }
        return [
            "id" => $this->id,
            "name" => $this->name,
            "position" => $this->position,
            "playerSkills" => [
                $this->skills
            ]
        ];
    }
}

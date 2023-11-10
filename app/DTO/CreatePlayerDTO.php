<?php

namespace App\DTO;

use App\Http\Requests\StoreUpdatePlayerRequest;

class CreatePlayerDTO
{
    public function __construct(
        public string $name,
        public string $position,
    ) {
    }

    public static function makeFromRequest(StoreUpdatePlayerRequest $request): self
    {
        return new self(
            $request->name,
            $request->position,
        );
    }
}

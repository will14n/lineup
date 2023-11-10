<?php

namespace App\DTO;

use App\Http\Requests\StoreUpdatePlayerRequest;

class UpdatePlayerDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string  $position,
    ) {
    }

    public static function makeFromRequest(StoreUpdatePlayerRequest $request, int $id = null): self
    {
        return new self(
            $id,
            $request->name,
            $request->position,
        );
    }
}

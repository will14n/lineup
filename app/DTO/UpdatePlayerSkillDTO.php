<?php

namespace App\DTO;

class UpdatePlayerSkillDTO
{
    public function __construct(
        public int $id,
        public string $skill,
        public string|null $value,
    ) {
    }

    public static function makeFromRequest($request, int $id = null): self
    {
        return new self(
            $id,
            $request['skill'],
            $request['value'] ?? 0,
        );
    }
}

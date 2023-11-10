<?php

namespace App\DTO;

class CreatePlayerSkillDTO
{
    public function __construct(
        public string $skill,
        public string|null $value,
        public int $player_id,
    ) {
    }

    public static function makeFromRequest(array $request, $playerId): self
    {
        return new self(
            $request['skill'],
            $request['value'] ?? 0,
            $playerId,
        );
    }
}

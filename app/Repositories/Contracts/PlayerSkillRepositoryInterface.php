<?php

namespace App\Repositories\Contracts;

use App\DTO\CreatePlayerSkillDTO;
use App\DTO\UpdatePlayerSkillDTO;
use stdClass;

interface PlayerSkillRepositoryInterface
{
    public function getAll(int $id): array;
    public function getOne(int $id): stdClass|null;
    public function new(CreatePlayerSkillDTO $dto): stdClass;
    public function update(UpdatePlayerSkillDTO $dto, $index): stdClass|null;
}

<?php

namespace App\Repositories\Contracts;

use App\DTO\CreatePlayerDTO;
use App\DTO\UpdatePlayerDTO;
use Illuminate\Http\Request;
use stdClass;

interface PlayerRepositoryInterface
{
    public function getAll(): array;
    public function getOne(int $id): stdClass|null;
    public function new(CreatePlayerDTO $dto): stdClass;
    public function update(UpdatePlayerDTO $dto): stdClass|null;
    public function delete(int $id): void;
    public function searchLineup(array $request): stdClass|null;
}

<?php

namespace App\Repositories\Eloquent;

use App\DTO\{
    CreatePlayerSkillDTO,
    UpdatePlayerSkillDTO,
};
use App\Models\PlayerSkill;
use App\Repositories\Contracts\PlayerSkillRepositoryInterface;
use Illuminate\Support\Arr;
use stdClass;

class PlayerSkillEloquentORM implements PlayerSkillRepositoryInterface
{

    public function __construct(
        protected PlayerSkill $model,
    ) {
    }

    public function getAll(int $id): array
    {
        return $this->model->where('player_id', $id)->get()->toArray();
    }

    public function getOne(int $id): stdClass|null
    {
        if (!$playerSkill = $this->model->find($id)) {
            return null;
        }
        return (object) $playerSkill->toArray();
    }

    public function new(CreatePlayerSkillDTO $dto): stdClass
    {
        $playerSkill = $this->model->create(
            (array) $dto
        );
        return (object) $playerSkill->toArray();
    }

    public function update(UpdatePlayerSkillDTO $dto, $index): stdClass|null
    {
        $playerSkills = $this->model->where('player_id', $dto->id)->get()->toArray();
        if ($index >= sizeof($playerSkills)) {
            return (object) $this->model->create(Arr::add((array)$dto, 'player_id', $dto->id))->toArray();
        }
        $playerSkill = $this->model->find($playerSkills[$index]['id'])->update((array) $dto);

        return (object) $this->model->find($dto->id)->toArray();
    }
}

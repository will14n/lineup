<?php

namespace App\Services;

use App\DTO\CreatePlayerDTO;
use App\DTO\CreatePlayerSkillDTO;
use App\DTO\UpdatePlayerDTO;
use App\DTO\UpdatePlayerSkillDTO;
use App\Http\Requests\StoreUpdatePlayerRequest;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use App\Repositories\Contracts\PlayerSkillRepositoryInterface;
use Illuminate\Http\Request;
use stdClass;

class PlayerService
{
    public function __construct(
        protected PlayerRepositoryInterface $playerRepository,
        protected PlayerSkillRepositoryInterface $playerSkillRepository,
    ) {
    }

    public function getAll(): array
    {
        return $this->playerRepository->getAll();
    }

    public function getOne(int $id): stdClass|null
    {
        return $this->playerRepository->getOne($id);
    }
    public function new(StoreUpdatePlayerRequest $request): stdClass
    {
        $player = $this->playerRepository->new(CreatePlayerDTO::makeFromRequest($request));
        foreach ($request->playerskills as $index => $playerSkill) {
            $this->playerSkillRepository->new(CreatePlayerSkillDTO::makeFromRequest($playerSkill, $player->id));
        }
        return $this->playerRepository->getOne($player->id);
    }

    public function update(StoreUpdatePlayerRequest $request, int $id): stdClass|null
    {
        $player = $this->playerRepository->update(UpdatePlayerDTO::makeFromRequest($request, $id));
        foreach ($request->playerskills as $index => $playerSkill) {
            $this->playerSkillRepository->update(UpdatePlayerSkillDTO::makeFromRequest($playerSkill, $id), $index);
        }
        return $this->playerRepository->getOne($id);
    }

    public function delete(int $id): void
    {
        $this->playerRepository->delete($id);
    }

    public function searchLineup(Request $request): stdClass
    {
        return $this->playerRepository->searchLineup(current($request->request));
    }
}

<?php

namespace App\Repositories\Eloquent;

use App\DTO\{
    CreatePlayerDTO,
    UpdatePlayerDTO,
};
use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use stdClass;

class PlayerEloquentORM implements PlayerRepositoryInterface
{

    public function __construct(
        protected Player $playerModel,
    ) {
    }

    public function getAll(): array
    {
        return $this->playerModel->select(['id', 'name', 'position'])->get()->toArray();
    }

    public function getOne(int $id): stdClass|null
    {
        if (!$player = $this->playerModel->find($id)) {
            return null;
        }
        return (object) $player->toArray();
    }

    public function delete(int $id): void
    {
        $this->playerModel->findOrFail($id)->delete();
    }

    public function new(CreatePlayerDTO $dto): stdClass
    {
        $player = $this->playerModel->create(
            (array) $dto
        )->toArray();
        return (object) $player;
    }

    public function update(UpdatePlayerDTO $dto): stdClass|null
    {
        if (!$player = $this->playerModel->find($dto->id)) {
            return null;
        }

        $player->update(
            (array) $dto
        );

        return (object) $player->toArray();
    }

    public function searchLineup(array $request): stdClass|null
    {
        $players = "";
        $response = [];
        foreach ($request as $index => $value) {
            $requestTemp = [];
            $res = $this->playerModel
                ->selectRaw('players.id, players.name, players.position, player_skills.skill, player_skills.value')
                ->join('player_skills', 'players.id', '=', 'player_skills.player_id')
                ->where('position', '=', $value['position'])
                ->where('player_skills.skill', '=', $value['mainSkill'])
                ->when($players != "", function ($query, $players) {
                    $query->whereNotIn('players.id', [substr($players, 1)]);
                })
                ->orderBy('player_skills.value', 'DESC')
                ->groupBy('players.id')
                ->limit($value['numberOfPlayers']);
            if ($value['numberOfPlayers'] > 1) {
                if (sizeof($res->get()->toArray()) > 0) {
                    foreach ($res->get()->toArray() as $idx => $item) {
                        $response[] = $item;
                    }
                    $players = $players . "," . implode(',', array_column($res->get()->toArray(), 'id'));
                    $requestTemp[] = $res->get()->toArray();
                }
            } else {
                if (sizeof($res->get()->toArray()) > 0) {
                    $response[] = current($res->get()->toArray());
                    $players = $players . "," . current($res->get()->toArray())['id'];
                    $requestTemp[] = $res->get()->toArray();
                }
            }
            if ($value['numberOfPlayers'] < sizeof($requestTemp)) {
                $players = "";
                $response = [];
                $this->playerModel
                    ->selectRaw('players.id, players.name, players.position, player_skills.skill, player_skills.value')
                    ->join('player_skills', 'players.id', '=', 'player_skills.player_id')
                    ->where('position', '=', $value['position'])
                    ->when($players != "", function ($query, $players) {
                        $query->whereNotIn('players.id', [substr($players, 1)]);
                    })
                    ->orderBy('player_skills.value', 'DESC')
                    ->groupBy('players.id')
                    ->limit($value['numberOfPlayers']);
                if ($value['numberOfPlayers'] > 1) {
                    foreach ($res->get()->toArray() as $idx => $item) {
                        $response[] = $item;
                    }
                    $players = $players . "," . implode(',', array_column($res->get()->toArray(), 'id'));
                } else {

                    $response[] = current($res->get()->toArray());
                    $players = $players . "," . $res->get()->toArray()[0]['id'];
                }
            }
        }
        return (object) $response;
    }
}


// 'defender'
// 'midfielder'
// 'forward'



// The skill will have:

// skill name
// value



// The available skills for a player are:

// '    '
// 'attack'
// 'speed'
// 'strength'
// 'stamina'

<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Http\Requests\IndexTeamRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    public function __construct(
        protected PlayerService $service,
    ) {
    }
    public function lineup(IndexTeamRequest $request)
    {
        $players = $this->service->searchLineup($request);
        return new PlayerResource($players);
        return response()->json(
            $players,
            Response::HTTP_OK
        );
    }
}

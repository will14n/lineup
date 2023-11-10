<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Adapters\ApiAdapter;
use App\Http\Requests\StoreUpdatePlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    public function __construct(
        protected PlayerService $service,
    ) {
    }

    public function index()
    {
        if (!$players = $this->service->getAll()) {
            return response()->json([
                'message' => "No players found"
            ], Response::HTTP_NOT_FOUND);
        }
        return ApiAdapter::toJson($players);
    }

    public function show(Request $request)
    {
        if (!$player = $this->service->getOne($request->playerId)) {
            return response()->json(['message' => "Invalid value for id: {$request->playerId}"
            ], Response::HTTP_NOT_FOUND);
        }
        return new PlayerResource($player);
    }

    public function store(StoreUpdatePlayerRequest $request)
    {
        $player = $this->service->new($request);
        $response = new PlayerResource($player);
        return $response->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(StoreUpdatePlayerRequest $request, int $id)
    {
        if (!$this->service->getOne($id)) {
            return response()->json([
                'message' => "Invalid value for id: {$id}"
            ], Response::HTTP_NOT_FOUND);
        }
        $player = $this->service->update($request, $id);
        $response = new PlayerResource($player);
        return $response->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Request $request, $id)
    {
        if (preg_grep('/^auth/i', array_keys($request->header()))) {
            $token = current($request->header()[current(preg_grep('/^auth/i', array_keys($request->header())))]);
            if ($token === env("BEARER")) {
                if (!Player::where('id', $id)->first()) {
                    return response()->json([
                        'message' => "Invalid value for id: {$id}"
                    ], Response::HTTP_NOT_FOUND);
                }
                Player::destroy($id);
                return response()->json([
                    'message' => "Resource deleted successfully"
                ], Response::HTTP_NO_CONTENT);
            }
        }

        return response()->json([
            'message' => "Invalid value for Authorization: empty"
        ], Response::HTTP_UNAUTHORIZED);
    }
}

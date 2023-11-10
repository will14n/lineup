<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\PlayerSkill;

class PlayerControllerListingTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $res = $this->get(self::REQ_URI);

        $this->assertNotNull($res);
    }

    public function test_show_player_route()
    {
        $playerId = PlayerSkill::factory()->create()->player_id;

        $res = $this->get(self::REQ_URI . $playerId);
        $res->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "position",
                "playerSkills" => [
                    [[
                        "id",
                        "skill",
                        "value",
                        "player_id"
                    ]]
                ]
            ]);
        $this->assertNotNull($res);
    }

    public function test_index_player_route()
    {
        $playerSkills = PlayerSkill::factory(3)->create()->toArray();

        $res = $this->get(self::REQ_URI);
        $res->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([[
                "id",
                "name",
                "position",
                "playerSkills" => [
                    [
                        "id",
                        "skill",
                        "value",
                        "player_id"
                    ]
                ]
            ]]);
        $this->assertNotNull($res);
    }
}

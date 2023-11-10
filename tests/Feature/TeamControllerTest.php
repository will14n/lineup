<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\PlayerSkill;

class TeamControllerTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $requirements =
            [
                'position' => "defender",
                'mainSkill' => "speed",
                'numberOfPlayers' => 1
            ];


        $res = $this->postJson(self::REQ_TEAM_URI, $requirements);

        $this->assertNotNull($res);
    }

    public function test_team_process_route_correct_structure()
    {
        $data = [
            0 => [
            "position" => "midfielder",
            "mainSkill" => "speed",
            "numberOfPlayers" => 1
        ]];

        PlayerSkill::factory(50)->create()->toArray();
        $res = $this->postJson(self::REQ_TEAM_URI, $data);
        $res->assertStatus(200);
        $this->assertNotNull($res);
    }
}

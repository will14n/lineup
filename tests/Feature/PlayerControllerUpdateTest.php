<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\PlayerSkill;

class PlayerControllerUpdateTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $data = [
            "name" => "test",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "attack",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ];

        $res = $this->putJson(self::REQ_URI . '1', $data);

        $this->assertNotNull($res);
    }

    public function test_without_value_param(): void
    {
        $data = [
            "name" => "test",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "attack"
                ]
            ]
        ];
        $playerId = PlayerSkill::factory()->create()->player_id;

        $res = $this->putJson(self::REQ_URI . $playerId, $data);
        $res->assertStatus(200)
            ->assertJsonStructure(["id",
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

    public function test_without_skill_param(): void
    {
        $data = [
            "name" => "test",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "value" => 80
                ]
            ]
        ];
        $playerId = PlayerSkill::factory()->create()->player_id;

        $res = $this->putJson(self::REQ_URI . $playerId, $data);
        $res->assertStatus(400)
            ->assertJson([
                "message" => "Invalid value for skill: empty"
            ]);
        $this->assertNotNull($res);
    }
}

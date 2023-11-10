<?php


// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;


class PlayerControllerCreateTest extends PlayerControllerBaseTest
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

        $res = $this->postJson(self::REQ_URI, $data);
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

        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(201)
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

        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(400)
            ->assertJson([
                "message" => "Invalid value for skill: empty"
            ]);
        $this->assertNotNull($res);
    }
}

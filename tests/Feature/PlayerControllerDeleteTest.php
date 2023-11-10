<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;

class PlayerControllerDeleteTest extends PlayerControllerBaseTest
{

    public function test_sample()
    {
        $res = $this->delete(self::REQ_URI . '1');

        $this->assertNotNull($res);
    }

    public function test_valid_id_param_with_correct_token()
    {
        $player = Player::factory()->create();
        $res = $this->delete(self::REQ_URI . $player->id, [], ['Authorizartion' => env('BEARER')]);
        $res->assertStatus(204);
    }

    public function test_valid_id_param_with_no_token()
    {
        $player = Player::factory()->create();
        $res = $this->delete(self::REQ_URI . $player->id);
        $res->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ])
            ->assertJson([
                'message' => 'Invalid value for Authorization: empty'
            ]);
    }

    public function test_valid_id_param_with_incorrect_token()
    {
        $player = Player::factory()->create();
        $res = $this->delete(self::REQ_URI . $player->id, [], ['Authorization', 'Bearer all***']);
        $res->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ])
            ->assertJson([
                'message' => 'Invalid value for Authorization: empty'
            ]);
    }

    public function test_invalid_id_param_with_correct_token()
    {
        $res = $this->delete(self::REQ_URI . '0', [], ['Authorizartion' => env('BEARER')]);
        $res->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ])
            ->assertJson([
                'message' => 'Invalid value for id: 0'
            ]);
        $this->assertNotNull($res);
    }

    public function test_invalid_id_param_with_no_token()
    {
        $res = $this->delete(self::REQ_URI . '0');
        $res->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ])
            ->assertJson([
                'message' => 'Invalid value for Authorization: empty'
            ]);
        $this->assertNotNull($res);
    }

    public function test_invalid_id_param_with_invalid_token()
    {
        $res = $this->delete(self::REQ_URI . '0', [], ['Authorization', 'Bearer all***']);
        $res->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ])
            ->assertJson([
                'message' => 'Invalid value for Authorization: empty'
            ]);
        $this->assertNotNull($res);
    }
}

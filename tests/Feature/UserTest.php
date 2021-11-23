<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *
     * @return void
     */
    public function test_getユーザー取得()
    {
        $token = Str::random(80);

        $user = factory(User::class)->create([
            'api_token' => hash('sha256', $token),
        ]);

        $response = $this->actingAs($user)->json('GET', "/api/user?api_token={$token}");
        $json = json_decode($response->getContent());
        $this->assertObjectHasAttribute('id', $json);
        $this->assertObjectHasAttribute('name', $json);
        $this->assertObjectHasAttribute('email', $json);
    }

    /**
     *
     *
     * @return void
     */
    public function test_postユーザー取得()
    {
        $token = Str::random(80);

        $user = factory(User::class)->create([
            'api_token' => hash('sha256', $token),
        ]);

        $response = $this
            ->actingAs($user)
            ->withHeaders(
                [
                    'Authorization' => "Bearer ${token}",
                ]
            )
            ->post('/api/user');
        $json = json_decode($response->getContent());
        $this->assertObjectHasAttribute('id', $json);
        $this->assertObjectHasAttribute('name', $json);
        $this->assertObjectHasAttribute('email', $json);
    }
}

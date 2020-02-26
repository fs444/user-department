<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = new User([
            'email' => 'admin@test.loc',
            'password' => 'password'
        ]);

        $this->be($user);
        
        $response = $this->get('/');

        $response->assertStatus(200);
        
        $user_data = [
            'user_name' => 'user3',
            'user_email' => 'user3@test.loc',
            'user_password' => 'password'
        ];
        
        $user->create($user_data);
    }
}

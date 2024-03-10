<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'account' => 'john_doe',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'cellphone' => '123456789',
            'birthday' => '1990-01-01',
        ]);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    /** @test */
    public function it_can_hide_sensitive_attributes()
    {
        $user = User::factory()->create([
            'account' => 'jane_doe',
            'password' => 'secret',
            'cellphone' => '987654321',
            'birthday' => '1990-01-01',
        ]);

        $hiddenAttributes = $user->getHidden();

        $this->assertContains('password', $hiddenAttributes);
        $this->assertNotContains('email', $hiddenAttributes);
    }
}



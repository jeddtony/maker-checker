<?php
namespace Tests;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthenticatedTestCase extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        // $this->actingAs($user, 'api');
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }
}
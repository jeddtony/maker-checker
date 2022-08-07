<?php

namespace Tests\Feature;

use App\Models\User;
use App\Uuid\CustomUuid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AuthenticatedTestCase;
use Tests\TestCase;

class PendingRequestTest extends AuthenticatedTestCase
{

    use RefreshDatabase;
    protected $user;
    public function setUp(): void
    {
        parent::setUp();

        // setup user to use for testing

        $this->user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'uuid' => CustomUuid::generateUuid('User')
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A test that an admin can create request.
     *
     * @return void
     */
    public function testAdminCanCreateRequest()
    {
        $response = $this->post('api/v1/pending-request', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@mail.vom',
            'password' => 'password'
        ]);

        $response->assertStatus(201);
    }

    /**
     * A test that an admin can create an update request.
     *
     * @return void
     */
    public function testAdminCanUpdateRequest()
    {
        $response = $this->put('api/v1/pending-request/' . $this->user->uuid, [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'new@email.com'
        ]);

        $response->assertStatus(201);
    }

    /**
     * A test that an admin can create an delete request.
     *
     * @return void
     */
    public function testAdminCanDeleteRequest()
    {
        $response = $this->delete('api/v1/pending-request/' . $this->user->uuid);

        $response->assertStatus(200);
    }

    /**
     * A test that an admin can view pending requests.
     *
     * @return void
     */
    public function testAdminCanViewRequests()
    {
       $response = $this->get('api/v1/pending-request/');
       $response->assertStatus(200);
    }
}

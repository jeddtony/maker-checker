<?php

namespace Tests\Feature;

use App\AdminAction\CreateAction;
use App\AdminAction\UpdateAction;
use App\Models\PendingRequest;
use App\Models\User;
use App\Uuid\CustomUuid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminActionTest extends TestCase
{
    protected $pendingRequest;
    protected $user;
    // setup 
    public function setUp(): void
    {
        parent::setUp();
        $this->pendingRequest = new PendingRequest();
        $this->pendingRequest->first_name = 'John';
        $this->pendingRequest->last_name = 'Doe';
        $this->pendingRequest->email = 'john@mail.com';
        $this->pendingRequest->password = 'password';
        $this->pendingRequest->uuid = CustomUuid::generateUuid('PendingRequest');

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
     * A test that a pending request can create a user.
     *
     * @return void
     */
    public function testPendingRequestCanCreateUser()
    {
        $createAction = new CreateAction();
        $createAction = $createAction->execute($this->pendingRequest);

        $this->assertInstanceOf(User::class, $createAction);
    }

    /**
     * A test that a pending request can update a user.
     *
     * @return void
     */
    // public function testPendingRequestCanUpdateUser()
    // {
    //     $this->pendingRequest->user_uuid = $this->user->uuid;

    //     $createAction = new UpdateAction();
    //     $createAction = $createAction->execute($this->pendingRequest);

    //     $this->assertInstanceOf(User::class, $createAction);
    // }

    
}

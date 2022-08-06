<?php

namespace Tests\Unit;

use App\Uuid\CustomUuid;
use Tests\TestCase;

class CustomUuidTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

     /**
     * Can generate a UUID.
     *
     * @return void
     */
    public function testCanGenerateUuid(){
        $uuid = CustomUuid::generateUuid('User');
        $this->assertTrue(!empty($uuid));
        $this->assertTrue(strlen($uuid) == 36);
    }
}

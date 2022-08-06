<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('pending_requests')) {
            Schema::create('pending_requests', function (Blueprint $table) {
                $table->id();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email');
                $table->string('password')->nullable();
                $table->string('uuid')->unique();
                $table->string('user_uuid')->comment('User id for whom the request is made')->nullable();
                $table->enum('request_type', ['create', 'update', 'delete']);
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->string('admin_uuid')->nullable()->comment('Admin id who created the request');
                $table->string('review_admin_uuid')->nullable()->comment('Admin id who acted on the request');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_requests');
    }
}

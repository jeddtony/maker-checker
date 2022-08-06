<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToPendingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_requests', function (Blueprint $table) {
            //
            if(!Schema::hasColumn('pending_requests', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pending_requests', function (Blueprint $table) {
            //
            if(Schema::hasColumn('pending_requests', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $update = 'ALTER TABLE posts MODIFY content text;';
        DB::statement($update);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $dropUpdate = 'ALTER TABLE posts MODIFY content varchar(255);';
        DB::statement($dropUpdate);
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        \Illuminate\Support\Facades\DB::update('ALTER TABLE settings DROP COLUMN id');

        Schema::table('settings', function (Blueprint $table) {


            $table->primary(['type'], 'pk_settings');


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::update('ALTER TABLE settings ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');

        Schema::table('settings', function (Blueprint $table) {
            $table->dropPrimary('pk_settings');
        });
    }
};

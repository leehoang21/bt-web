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
        Schema::drop('user_addresses');

        Schema::create('user_addresses', function (Blueprint $table) {
            $table->integer('id_user');
            $table->String('address');
            $table -> String('full_name') ;
            $table -> String('phone') ;
            $table->id('id');
            $table->timestamps();

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

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
        Schema::create('product_categories', function (Blueprint $table) {

            $table -> integer('id_product');
            $table -> integer('id_category');
            $table->timestamps();
            $table->primary(['id_product', 'id_category'], 'pk_product_category');
            $table->unique(['id_product', 'id_category'], 'unique_product_category');


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};

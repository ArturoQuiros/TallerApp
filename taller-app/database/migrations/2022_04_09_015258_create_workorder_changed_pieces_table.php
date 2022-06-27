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
        Schema::create('workorder_changed_pieces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workorder_id');
            $table->unsignedBigInteger('piece_id');
            $table->double('quantity');
            $table->timestamps();
            /*NOW THE REFERENCES FOR FOREIGN KEYS*/ 
            $table->foreign('workorder_id')->references('id')->on('workorders');
            $table->foreign('piece_id')->references('id')->on('pieces');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workorder_changed_pieces');
    }
};

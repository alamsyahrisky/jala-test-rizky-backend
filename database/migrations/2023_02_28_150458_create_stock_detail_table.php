<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('stock_id');
            $table->foreign('stock_id')->references('id')->on('stock')->onDelete('cascade');
            $table->enum('type', ['in', 'out'])->nullable();
            $table->integer('quantity');
            $table->string('number');
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
        Schema::dropIfExists('stock_detail');
    }
}

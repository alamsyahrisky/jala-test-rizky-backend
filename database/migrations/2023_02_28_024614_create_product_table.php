<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sku', 20)->unique();
            $table->string('name', 200);
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('price')->unsigned()->nullable()->default(12);
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade');
            $table->string('condition')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('stok')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flowers', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('name');  // Flower name
            $table->string('category');  // Category (e.g., Funeral, Bouquet)
            $table->decimal('price', 10, 2);  // Price with 2 decimal places
            $table->unsignedTinyInteger('rating')->default(0);  // Rating (0-5)
            $table->string('image_path')->nullable();  // Path to image file
            $table->text('description')->nullable();  // Optional description
            $table->timestamps();  // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flowers');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string("location")->nullable();
            $table->date('start_date');
            $table->integer('available_seats');
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
           /* $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories'); //another way */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

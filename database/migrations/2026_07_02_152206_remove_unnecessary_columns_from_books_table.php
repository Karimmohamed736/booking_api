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
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn(['title', 'price', 'desc']);
    });
}

public function down(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->string('title')->nullable();
        $table->decimal('price', 8, 2)->nullable();
        $table->text('desc')->nullable();
    });
}
};

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('cover');
            $table->unsignedBigInteger('price');
            $table->text('about');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('creator_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('diskon_id')
              ->nullable()
              ->after('creator_id') // Posisi kolom
              ->constrained()
              ->onDelete('set null'); // Boleh null jika produk tidak selalu diskon
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['diskon_id']);
            $table->dropColumn('diskon_id');
        });
    }
};

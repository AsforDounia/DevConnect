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
        Schema::table('posts', function (Blueprint $table) {
            $table -> dropColumn('image');
            $table -> dropColumn('code');
            $table -> dropColumn('link');
            $table -> dropColumn("likes");
            $table -> enum('post_type',['image','code','link']) -> nullable();
            $table -> text("content_type") -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image');
            $table->string('code');
            $table->string('link');
            $table->integer('likes');
        });
    }
};

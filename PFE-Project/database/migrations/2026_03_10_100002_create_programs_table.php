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
       Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_staff_id'); // Relation m3a Staff
            $table->string('title');
            $table->timestamps(); // create_at is included here
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};

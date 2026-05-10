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
        Schema::table('evolutions', function (Blueprint $table) {
            $table->json('images')->nullable()->after('weight');
        });

        // Migrate existing data
        \DB::table('evolutions')->get()->each(function ($evolution) {
            if ($evolution->body_img_url) {
                \DB::table('evolutions')
                    ->where('id', $evolution->id)
                    ->update(['images' => json_encode([$evolution->body_img_url])]);
            } else {
                 \DB::table('evolutions')
                    ->where('id', $evolution->id)
                    ->update(['images' => json_encode([])]);
            }
        });

        Schema::table('evolutions', function (Blueprint $table) {
            $table->dropColumn('body_img_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evolutions', function (Blueprint $table) {
            $table->string('body_img_url')->nullable()->after('weight');
        });

        // Reverse migration
        \DB::table('evolutions')->get()->each(function ($evolution) {
            $images = json_decode($evolution->images, true);
            if (!empty($images)) {
                \DB::table('evolutions')
                    ->where('id', $evolution->id)
                    ->update(['body_img_url' => $images[0]]);
            }
        });

        Schema::table('evolutions', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }

};

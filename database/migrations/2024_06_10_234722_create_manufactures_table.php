<?php

declare(strict_types=1);

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
        Schema::create('manufactures', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->string('name');

            $table->userstamps();
            $table->timestamps();
            $table->softDeletes();

            $table->index('id', 'manufactures_id_idx', 'hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufactures');
    }
};

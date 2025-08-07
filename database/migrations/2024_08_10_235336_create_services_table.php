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
        Schema::create('services', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->string('code')->unique();
            $table->ulid('post_id')->index();
            $table->ulid('category_id')->index();

            $table->userstamps();
            $table->timestamps();
            $table->softDeletes();

            $table->index('id', 'services_id_idx', 'hash');
            $table->index('code', 'services_code_idx', 'hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

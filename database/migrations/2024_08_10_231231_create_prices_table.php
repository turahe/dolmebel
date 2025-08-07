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
        Schema::create('prices', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->ulidMorphs('model');
            $table->string('currency')->default('IDR')->index();
            $table->decimal('cogs', 64)->index()->default(0);
            $table->decimal('sale', 64)->index()->default(0);
            $table->json('metadata')->nullable();

            $table->userstamps();
            $table->timestamps();
            $table->softDeletes();

            $table->index('id', 'prices_id_idx', 'hash');
            $table->index('model_id', 'prices_model_id_idx', 'hash');
            $table->index('model_type', 'prices_model_type_idx', 'hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};

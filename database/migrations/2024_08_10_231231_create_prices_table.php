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
            if (config('userstamps.users_table_column_type') === 'bigincrements') {
                $table->id();
            }
            if (config('userstamps.users_table_column_type') === 'ulid') {
                $table->ulid('id')->primary();
            }
            if (config('userstamps.users_table_column_type') === 'uuid') {
                $table->uuid('id')->primary();
            }
            $table->ulidMorphs('model');
            $table->string('currency')->default('IDR')->index();
            $table->decimal('cogs', 64)->index()->default(0);
            $table->decimal('sale', 64)->index()->default(0);
            $table->json('metadata')->nullable();

            // Add userstamp columns
            $userstampsType = config('userstamps.users_table_column_type', 'bigincrements');
            if ($userstampsType === 'ulid') {
                $table->ulid('created_by')->nullable()->index();
                $table->ulid('updated_by')->nullable()->index();
                $table->ulid('deleted_by')->nullable()->index();
            } elseif ($userstampsType === 'uuid') {
                $table->uuid('created_by')->nullable()->index();
                $table->uuid('updated_by')->nullable()->index();
                $table->uuid('deleted_by')->nullable()->index();
            } else {
                $table->unsignedBigInteger('created_by')->nullable()->index();
                $table->unsignedBigInteger('updated_by')->nullable()->index();
                $table->unsignedBigInteger('deleted_by')->nullable()->index();
            }

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints will be added in a separate migration
            // to avoid PostgreSQL constraint issues

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

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
        Schema::create('banks', function (Blueprint $table): void {
            if (config('userstamps.users_table_column_type') === 'bigincrements') {
                $table->id();
            }
            if (config('userstamps.users_table_column_type') === 'ulid') {
                $table->ulid('id')->primary();
            }
            if (config('userstamps.users_table_column_type') === 'uuid') {
                $table->uuid('id')->primary();
            }
            $table->string('bank_id')->index();
            $table->ulidMorphs('holder');
            $table->string('label')->index();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->index()->nullable();
            $table->string('account_holder');
            $table->string('account_number')->index();
            $table->text('note')->nullable();            // Add userstamp columns
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

            // Foreign key constraints will be added in a separate migration`n            // to avoid PostgreSQL constraint issues

            $table->index('id', 'banks_id_idx', 'hash');
            $table->index('holder_id', 'banks_holder_id_idx', 'hash');
            $table->index('holder_type', 'banks_holder_type_idx', 'hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};

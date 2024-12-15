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
            $table->ulid('id')->primary();
            $table->string('bank_id')->index();
            $table->ulidMorphs('holder');
            $table->string('label')->index();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->index()->nullable();
            $table->string('account_holder');
            $table->string('account_number')->index();
            $table->text('note')->nullable();

            $table->userstamps();
            $table->softUserstamps();

            $table->integer('deleted_at')->index()->nullable();
            $table->integer('created_at')->index()->nullable();
            $table->integer('updated_at')->index()->nullable();

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

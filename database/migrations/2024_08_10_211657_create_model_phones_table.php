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
        Schema::create('model_phones', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->ulidMorphs('model');
            $table->string('number')->index()->unique();
            $table->string('country_id')->index();
            $table->enum('type', array_column(\App\Enums\PhoneType::cases(), 'value'))->index();

            $table->userstamps();
            $table->timestamps();
            $table->softDeletes();

            $table->index('id', 'phones_id_idx', 'hash');
            $table->index('model_id', 'phones_model_id_idx', 'hash');
            $table->index('model_type', 'phones_model_type_idx', 'hash');
            $table->index('country_id', 'phones_country_id_idx', 'hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_phones');
    }
};

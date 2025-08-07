<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->string('name')->index();
            $table->string('file_name')->index();
            $table->string('disk');
            $table->string('mime_type');
            $table->unsignedInteger('size');
            $table->unsignedBigInteger('record_left')->index()->nullable();
            $table->unsignedBigInteger('record_right')->index()->nullable();
            $table->unsignedBigInteger('record_dept')->index()->nullable();
            $table->unsignedBigInteger('record_ordering')->index()->nullable();
            $table->foreignUlid('parent_id')->index()->nullable();
            $table->string('custom_attribute')->nullable();

            $table->userstamps();
            $table->timestamps();
            $table->softDeletes();

            $table->index('id', 'media_id_idx', 'hash');

        });

        Schema::create('mediables', function (Blueprint $table): void {
            $table->foreignUlid('media_id')->index();
            $table->ulid('mediable_id')->index();
            $table->string('mediable_type');
            $table->string('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mediables');
        Schema::dropIfExists('media');
    }
};

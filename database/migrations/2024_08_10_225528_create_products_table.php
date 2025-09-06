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
        Schema::create('products', function (Blueprint $table): void {
            if (config('userstamps.users_table_column_type') === 'bigincrements') {
                $table->id();
            }
            if (config('userstamps.users_table_column_type') === 'ulid') {
                $table->ulid('id')->primary();
            }
            if (config('userstamps.users_table_column_type') === 'uuid') {
                $table->uuid('id')->primary();
            }
            $table->string('qrcode')->unique();
            $table->string('barcode')->unique();
            $table->ulid('post_id')->index();
            $table->ulid('category_id')->index();
            $table->ulid('supplier_id')->nullable()->index();
            $table->ulid('brand_id')->nullable()->index();
            $table->ulid('manufacture_id')->nullable()->index();

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

            $table->index('id', 'products_id_idx', 'hash');
            $table->index('qrcode', 'products_qrcode_idx', 'hash');
            $table->index('barcode', 'products_barcode_idx', 'hash');
        });

        Schema::create('product_options', function (Blueprint $table): void {
            $table->ulid('product_id');
            $table->ulid('option_id');
            $table->uuid('option_group_id');
            $table->uuid('option_price_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_options');
        Schema::dropIfExists('products');
    }
};

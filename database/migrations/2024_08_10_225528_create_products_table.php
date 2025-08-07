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
            $table->ulid('id')->primary();
            $table->string('qrcode')->unique();
            $table->string('barcode')->unique();
            $table->ulid('post_id')->index();
            $table->ulid('category_id')->index();
            $table->ulid('supplier_id')->nullable()->index();
            $table->ulid('brand_id')->nullable()->index();
            $table->ulid('manufacture_id')->nullable()->index();

            $table->userstamps();
            $table->timestamps();
            $table->softDeletes();

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

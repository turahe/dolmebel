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
            $table->foreignIdFor(\Turahe\Post\Models\Post::class, 'post_id')->index();
            $table->foreignIdFor(\App\Models\Category::class, 'category_id')->index();
            $table->foreignIdFor(\Turahe\Core\Models\Organization::class, 'supplier_id')->nullable()->index();
            $table->foreignIdFor(\App\Models\Brand::class, 'brand_id')->nullable()->index();
            $table->foreignIdFor(\Turahe\Core\Models\Organization::class, 'manufacture_id')->nullable()->index();

            $table->userstamps();
            $table->softUserstamps();

            $table->integer('deleted_at')->index()->nullable();
            $table->integer('created_at')->index()->nullable();
            $table->integer('updated_at')->index()->nullable();

            $table->index('id', 'products_id_idx', 'hash');
            $table->index('qrcode', 'products_qrcode_idx', 'hash');
            $table->index('barcode', 'products_barcode_idx', 'hash');
        });

        Schema::create('product_options', function (Blueprint $table): void {
            $table->foreignIdFor(\App\Models\Product::class);
            $table->foreignIdFor(\App\Models\Category::class, 'option_id');
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

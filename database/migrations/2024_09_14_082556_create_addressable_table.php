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
        Schema::create('addresses', function (Blueprint $table): void {
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
            $table->string('label')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_billing')->default(false);
            $table->boolean('is_shipping')->default(false);
            $table->string('street_address1')->nullable();
            $table->string('street_address2')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code', 2)->nullable();
            //            $table->point('position', config('addressable.srid'))->nullable();            // Add userstamp columns
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};

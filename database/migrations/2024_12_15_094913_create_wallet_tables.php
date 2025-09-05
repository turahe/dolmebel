<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $walletModelClass = config('wallet.wallet_model');
        $walletTable = (new $walletModelClass)->getTable();
        if (! Schema::hasTable($walletTable)) {
            Schema::create($walletTable, function (Blueprint $table) {
                if (config('userstamps.users_table_column_type') === 'bigincrements') {
                    $table->id();
                }
                if (config('userstamps.users_table_column_type') === 'ulid') {
                    $table->ulid('id')->primary();
                }
                if (config('userstamps.users_table_column_type') === 'uuid') {
                    $table->uuid('id')->primary();
                }
                $table->unsignedInteger('owner_id')->nullable();
                $table->string('owner_type')->nullable();
                $type = config('wallet.column_type');
                if ($type == 'decimal') {
                    $table->decimal('balance', 12, 4)->default(0); // amount is an decimal, it could be "dollars" or "cents"
                } elseif ($type == 'integer') {
                    $table->integer('balance');
                }

                $table->timestamps();
                $table->softDeletes();

                // Add foreign key constraints for userstamps
                if (config('userstamps.users_table_column_type') === 'bigincrements') {
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                    $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
                    $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
                }

                if (config('userstamps.users_table_column_type') === 'ulid') {
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                    $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
                    $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
                }
                if (config('userstamps.users_table_column_type') === 'uuid') {
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                    $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
                    $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
                }
            });
        }
        $transactionModelClass = config('wallet.transaction_model');
        $transactionTable = (new $transactionModelClass)->getTable();
        if (! Schema::hasTable($transactionTable)) {
            Schema::create($transactionTable, function (Blueprint $table) {
                $table->ulid()->primary();
                $table->unsignedInteger('wallet_id');

                if (config('wallet.column_type') == 'decimal') {
                    $table->decimal('amount', 12, 4); // amount is an decimal, it could be "dollars" or "cents"
                } else {
                    $table->integer('amount');
                }

                $table->string('hash', 60); // hash is a uniqid for each transaction
                $table->string('type', 30); // type can be anything in your app, by default we use "deposit" and "withdraw"
                $table->json('meta')->nullable(); // Add all kind of meta information you need

                $table->integer('deleted_at')->index()->nullable();
                $table->integer('created_at')->index()->nullable();
                $table->integer('updated_at')->index()->nullable();
                $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $transactionModelClass = config('wallet.transaction_model');
        $transactionTable = (new $transactionModelClass)->getTable();
        Schema::dropIfExists($transactionTable);
        $walletModelClass = config('wallet.transaction_model');
        $walletTable = (new $walletModelClass)->getTable();
        Schema::dropIfExists($walletTable);
    }
};

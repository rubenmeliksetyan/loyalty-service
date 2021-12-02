<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyLoyaltyPointsTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty_points_transaction', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')
                ->on('loyalty_account')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty_points_transaction', function (Blueprint $table) {
            $table->dropForeign('loyalty_points_transaction_account_id_loyalty_account_foreign');
        });
    }
}

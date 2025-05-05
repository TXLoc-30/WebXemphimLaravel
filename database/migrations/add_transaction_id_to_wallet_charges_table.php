<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionIdToWalletChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet_charges', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('money'); // Thêm cột transaction_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_charges', function (Blueprint $table) {
            $table->dropColumn('transaction_id'); // Xóa cột transaction_id nếu rollback
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->constrained();
			$table->unsignedDecimal('amount', $precision = 8, $scale = 2);
			$table->unsignedInteger('tenure');
			$table->unsignedInteger('rate_of_interest')->default(10)->comment('Intrest Percentage');
            $table->enum('type',['Home Loan','Personal Loan'])->default('Home Loan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}

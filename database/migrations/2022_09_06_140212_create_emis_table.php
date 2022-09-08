<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emis', function (Blueprint $table) {
            $table->id();
			$table->foreignId('loan_id')->constrained();
			$table->unsignedInteger('emi_number');
			$table->unsignedDecimal('emi_amount', $precision = 8, $scale = 2);
			$table->unsignedDecimal('interest_amount', $precision = 8, $scale = 2);
			$table->enum('status',['1','0'])->default('0')->comment("1->Paid,0-> Unpaid");
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
        Schema::dropIfExists('emis');
    }
}

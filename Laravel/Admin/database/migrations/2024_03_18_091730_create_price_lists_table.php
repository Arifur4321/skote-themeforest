<?php
 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceListsTable extends Migration
{
    public function up()
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->string('pricename');
            $table->string('currency');
            $table->decimal('fixedvalue', 10, 2)->nullable();
            $table->decimal('dynamicminRange', 10, 2)->nullable();
            $table->decimal('dynamicmaxRange', 10, 2)->nullable();
            $table->string('enableVat')->nullable();
            $table->decimal('vatPercentage',10 ,2)->nullable();
            $table->string('price')->nullable();
            $table->string('external')->nullable();
            $table->string('selectPriceType')->nullable();
            $table->string('singlePayment')->nullable();
            $table->string('multiplePayments')->nullable();
            $table->decimal('paymentMinRange', 10, 2)->nullable();
            $table->decimal('paymentMaxRange', 10, 2)->nullable();
            $table->string('paymentExampleText')->nullable();
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
        Schema::dropIfExists('price_lists');
    }
}

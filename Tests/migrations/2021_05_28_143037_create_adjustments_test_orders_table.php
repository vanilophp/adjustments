<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentsTestOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('items_total', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('orders');
    }
}

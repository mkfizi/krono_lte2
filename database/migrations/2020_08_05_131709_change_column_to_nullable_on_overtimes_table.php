<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToNullableOnOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overtimes', function (Blueprint $table) {
            $table->integer('eligible_day')->default(0)->nullable()->change();
            $table->string('eligible_day_code')->nullable()->change();
            $table->decimal('eligible_total_hours_minutes', 10,2)->default(0)->nullable()->change();
            $table->string('eligible_total_hours_minutes_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overtimes', function (Blueprint $table) {
            //
        });
    }
}
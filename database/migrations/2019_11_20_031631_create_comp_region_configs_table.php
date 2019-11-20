<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompRegionConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp_region_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('comp_region_id');
            $table->decimal('salary_cap',10,2)->nullable();
            $table->integer('hourperday');
            $table->integer('daypermonth');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('comp_region_configs');
    }
}

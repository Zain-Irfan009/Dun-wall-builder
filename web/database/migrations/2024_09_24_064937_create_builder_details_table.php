<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuilderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('builder_details', function (Blueprint $table) {
            $table->id();
            $table->longText('unique_id')->nullable();
            $table->string('wall_width')->nullable();
            $table->string('wall_height')->nullable();
            $table->string('wall_unit')->nullable();
            $table->string('dun_width')->nullable();
            $table->string('dun_height')->nullable();
            $table->string('dun_unit')->nullable();
            $table->string('show_measurement')->nullable();
            $table->string('form_type')->nullable();
            $table->string('shape')->nullable();
            $table->string('vertical_density')->nullable();
            $table->string('horizontal_density')->nullable();
            $table->longText('image')->nullable();
            $table->longText('email')->nullable();
            $table->boolean('is_email_failed')->default(0);
            $table->longText('email_error')->nullable();

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
        Schema::dropIfExists('builder_details');
    }
}

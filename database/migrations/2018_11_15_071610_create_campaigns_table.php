<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('custom_url');
            $table->string('campaign');
            $table->string('source')->nullable();
            $table->string('medium')->nullable();
            $table->integer('click')->default(0);
            $table->integer('user_id');
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
//        Schema::dropIfExists('campaigns');
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('click');
        });
    }

}

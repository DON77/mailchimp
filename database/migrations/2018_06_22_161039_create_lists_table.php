<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string("mailchimp_list_id", 32);
            $table->integer("web_id");
            $table->string("name");
            $table->dateTime("date_created");
            $table->boolean("email_type_option")->nullable();
            $table->boolean("use_awesomebar")->nullable();
            $table->string("default_from_name")->nullable();
            $table->string("default_from_email")->nullable();
            $table->string("default_subject")->nullable();
            $table->string("default_language")->nullable();
            $table->integer("list_rating")->nullable();
            $table->string("subscribe_url_short")->nullable();
            $table->string("subscribe_url_long")->nullable();
            $table->string("beamer_address")->nullable();
            $table->string("visibility")->nullable();
//            "stats" => array:16 [▶]
//            "modules" => [];
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lists');
    }
}

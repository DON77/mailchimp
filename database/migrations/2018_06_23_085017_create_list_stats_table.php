<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("list_id");
            $table->integer("member_count");
            $table->integer("unsubscribe_count");
            $table->integer("cleaned_count");
            $table->integer("member_count_since_send");
            $table->integer("unsubscribe_count_since_send");
            $table->integer("cleaned_count_since_send");
            $table->integer("campaign_count");
            $table->integer("grouping_count");
            $table->integer("group_count");
            $table->integer("merge_var_count");
            $table->integer("avg_sub_rate");
            $table->integer("avg_unsub_rate");
            $table->integer("target_sub_rate");
            $table->integer("open_rate");
            $table->integer("click_rate");
            $table->integer("date_last_campaign")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_stats');
    }
}

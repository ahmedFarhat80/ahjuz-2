<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->string('hero_img')->nullable();
            $table->text('main_headline')->nullable();
            $table->text('main_text')->nullable();

            $table->string('play_store')->nullable();
            $table->string('apple_store')->nullable();
            $table->text('mobile_headline')->nullable();
            $table->text('mobile_text')->nullable();

            $table->text('address')->nullable();

            $table->string('phone')->nullable();

            $table->string('whatsapp_1')->nullable();
            $table->string('whatsapp_2')->nullable();

            $table->string('email')->nullable();

            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('youtube')->nullable();

            $table->text('footer_text')->nullable();

            $table->string('about_img')->nullable();
            $table->text('about_text')->nullable();

            $table->unsignedTinyInteger('commission');

            $table->char('restrict_to_one_row', 1)->default('x')->primary();
        });
        
        DB::statement('ALTER TABLE site_settings ADD CONSTRAINT chk_restrict_to_one_row CHECK (restrict_to_one_row = "x");');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DbStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('username')->unique();
            $table->integer('type')->default(false);
            $table->boolean('blocked')->default(false);
            $table->boolean('activated')->default(false);
            $table->string('avatar')->default('empty.png');
            $table->string('reason_blocked')->nullable();
            $table->string('reason_reactivated')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('activations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('token');
            $table->timestamps();
        });


        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('platform_email');
            $table->string('platform_email_properties');
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('description');
            $table->string('source');
            $table->date('pub_date');
            $table->timestamps();
        });

        Schema::create('rss_news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('website');
            $table->string('url');
        });

        Schema::create('rss_alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('website');
            $table->string('url');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('localization');
            $table->string('name');
            $table->string('organizer');
            $table->string('description');
            $table->date('date');
            $table->string('image_path');
            // 0 - por realizar
            // 1 - a decorrer
            // 2 - concluido
            $table->integer('status');
            $table->integer('id_user');
            $table->integer('total_interested')->default(0);
            $table->timestamps();
        });

        Schema::create('event_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->integer('id_event');
            $table->integer('status');
        });

        Schema::create('glossaries', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('definition');
            $table->string('source');
            $table->timestamps();
        });

        Schema::create('texts', function(Blueprint $table){
            $table->increments('id');
            $table->string('key');
            $table->longText('description');
            $table->timestamps();
        });

        Schema::create('useful_links', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
            $table->string('link');
            $table->timestamps();
        });

        Schema::create('documents', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
            $table->longText('path');
            $table->timestamps();
        });

        Schema::create('newsletter', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
            $table->date('date');
            $table->longText('path');
            $table->timestamps();
        });

        Schema::create('newsletter_subscription', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();;
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
        Schema::dropIfExists('newsletter_subscription');
        Schema::dropIfExists('newsletter');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('useful_links');
        Schema::dropIfExists('texts');
        Schema::dropIfExists('glossaries');
        Schema::dropIfExists('event_user');
        Schema::dropIfExists('event');
        Schema::dropIfExists('rss_alerts');
        Schema::dropIfExists('rss_news');
        Schema::dropIfExists('news');
        Schema::dropIfExists('config');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('activations');
        Schema::dropIfExists('users');
    }
}

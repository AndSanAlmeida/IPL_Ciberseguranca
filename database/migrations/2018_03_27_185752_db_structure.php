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
            $table->string('avatar')->default('img/avatars/empty.png');
            $table->string('reason_blocked')->nullable();
            $table->string('reason_reactivated')->nullable();
            $table->integer('total_forum_posts')->default(0);
            $table->integer('total_forum_comments')->default(0);
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
            $table->longText('text');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('id_user');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('text');
            $table->string('path_file');
            $table->integer('id_user');
            $table->timestamps();
        });

        Schema::create('forum_post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('text');
            $table->integer('up_vote')->default(0);
            $table->integer('down_vote')->default(0);
            $table->integer('number_of_comments')->default(0);
            $table->integer('id_user');
            $table->timestamps();
        });

        Schema::create('forum_post_user_rating', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->integer('id_post');
            $table->integer('rating');
        });

        Schema::create('forum_post_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment');
            $table->integer('id_user');
            $table->integer('id_post');
            $table->integer('up_vote')->default(0);
            $table->integer('down_vote')->default(0);
            $table->timestamps();
        });

        Schema::create('forum_post_comment_user_rating', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->integer('id_comment');
            $table->integer('rating');
        });

        Schema::create('rss', function (Blueprint $table) {
            $table->increments('id');
            $table->string('website');
            $table->string('url');
            $table->integer('id_user');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('localization');
            $table->string('name');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_user');
        Schema::dropIfExists('event');
        Schema::dropIfExists('rss');
        Schema::dropIfExists('forum_post_comment_user_rating');
        Schema::dropIfExists('forum_post_comment');
        Schema::dropIfExists('forum_post_user_rating');
        Schema::dropIfExists('forum_post');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('news');
        Schema::dropIfExists('config');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('activations');
        Schema::dropIfExists('users');
    }
}

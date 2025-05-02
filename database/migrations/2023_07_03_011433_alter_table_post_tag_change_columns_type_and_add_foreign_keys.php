<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePostTagChangeColumnsTypeAndAddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_tag', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('tag_id')->change();
            $table->unsignedBigInteger('post_id')->change();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('post_tag', function (Blueprint $table) {
            $table->dropForeign('post_tag_post_id_foreign');
            $table->dropForeign('post_tag_tag_id_foreign');
            $table->dropIndex('post_tag_post_id_foreign');
            $table->dropIndex('post_tag_tag_id_foreign');
        });

        Schema::enableForeignKeyConstraints();

        Schema::table('post_tag', function (Blueprint $table) {
            $table->increments('id')->change();
            $table->integer('tag_id')->unsigned()->change();
            $table->integer('post_id')->unsigned()->change();
        });
    }
}

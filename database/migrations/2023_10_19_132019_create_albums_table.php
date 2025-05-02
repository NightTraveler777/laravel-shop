<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profile_id')->unsigned();
            $table->bigInteger('genre_id')->unsigned()->nullable();
            $table->bigInteger('artist_id')->unsigned()->nullable();
            $table->bigInteger('label_id')->unsigned()->nullable();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('slug', 100)->unique();
            $table->string('cover', 50)->nullable();
            $table->json('format');
            $table->timestamps();

            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles')
                ->cascadeOnDelete();

            $table->foreign('genre_id')
                ->references('id')
                ->on('genres')
                ->nullOnDelete();

            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->nullOnDelete();

            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}

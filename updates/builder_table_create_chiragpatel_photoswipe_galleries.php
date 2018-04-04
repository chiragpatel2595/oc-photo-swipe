<?php namespace ChiragPatel\PhotoSwipe\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateChiragpatelPhotoswipeGalleries extends Migration
{
    public function up()
    {
       Schema::create('chiragpatel_photoswipe_galleries', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_published')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chiragpatel_photoswipe_galleries');
    }
}
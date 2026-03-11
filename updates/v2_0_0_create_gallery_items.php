<?php namespace ChiragPatel\PhotoSwipe\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class V200CreateGalleryItems extends Migration
{
    public function up()
    {
        Schema::create('chiragpatel_photoswipe_gallery_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('gallery_id');
            $table->string('type', 10)->default('image');
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_thumb_url')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('gallery_id')
                ->references('id')
                ->on('chiragpatel_photoswipe_galleries')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chiragpatel_photoswipe_gallery_items');
    }
}

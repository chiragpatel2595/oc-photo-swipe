<?php namespace ChiragPatel\PhotoSwipe\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class V200AddGalleryFields extends Migration
{
    public function up()
    {
        Schema::table('chiragpatel_photoswipe_galleries', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('layout', 20)->default('grid');
            $table->json('image_dimensions')->nullable();
        });
    }

    public function down()
    {
        Schema::table('chiragpatel_photoswipe_galleries', function (Blueprint $table) {
            $table->dropColumn(['description', 'layout', 'image_dimensions']);
        });
    }
}

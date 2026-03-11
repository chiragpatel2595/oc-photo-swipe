<?php namespace ChiragPatel\PhotoSwipe\Updates;

use Db;
use October\Rain\Database\Updates\Migration;

class V200MigrateExistingImages extends Migration
{
    public function up()
    {
        $galleries = Db::table('chiragpatel_photoswipe_galleries')->get();

        foreach ($galleries as $gallery) {
            $files = Db::table('system_files')
                ->where('attachment_type', 'ChiragPatel\PhotoSwipe\Models\Gallery')
                ->where('attachment_id', $gallery->id)
                ->where('field', 'images')
                ->orderBy('sort_order')
                ->get();

            foreach ($files as $index => $file) {
                $width = null;
                $height = null;

                $diskPath = storage_path('app/uploads/public/' . $file->disk_name);
                if (file_exists($diskPath)) {
                    $size = @getimagesize($diskPath);
                    if ($size) {
                        $width = $size[0];
                        $height = $size[1];
                    }
                }

                Db::table('chiragpatel_photoswipe_gallery_items')->insert([
                    'gallery_id' => $gallery->id,
                    'type' => 'image',
                    'title' => $file->title,
                    'caption' => $file->description,
                    'width' => $width,
                    'height' => $height,
                    'sort_order' => $index,
                    'created_at' => $file->created_at,
                    'updated_at' => $file->updated_at,
                ]);

                $itemId = Db::getPdo()->lastInsertId();

                // Re-associate the system_file to the new GalleryItem model
                Db::table('system_files')
                    ->where('id', $file->id)
                    ->update([
                        'attachment_type' => 'ChiragPatel\PhotoSwipe\Models\GalleryItem',
                        'attachment_id' => $itemId,
                        'field' => 'image',
                    ]);
            }
        }
    }

    public function down()
    {
        // Re-associate images back to Gallery model
        $items = Db::table('chiragpatel_photoswipe_gallery_items')
            ->where('type', 'image')
            ->get();

        foreach ($items as $item) {
            Db::table('system_files')
                ->where('attachment_type', 'ChiragPatel\PhotoSwipe\Models\GalleryItem')
                ->where('attachment_id', $item->id)
                ->where('field', 'image')
                ->update([
                    'attachment_type' => 'ChiragPatel\PhotoSwipe\Models\Gallery',
                    'attachment_id' => $item->gallery_id,
                    'field' => 'images',
                ]);
        }
    }
}

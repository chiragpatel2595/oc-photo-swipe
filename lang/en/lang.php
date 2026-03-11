<?php return [
    'plugin' => [
        'name' => 'Photo Swipe',
        'description' => 'Responsive photo galleries with PhotoSwipe v5 — touch support, zoom, layouts, and video.',
    ],
    'galleries' => [
        'backend_name' => 'Gallery',
        'title' => 'Title',
        'slug' => 'Slug',
        'description' => 'Description',
        'layout' => 'Layout',
        'images' => 'Images',
        'images_legacy' => 'Images (Legacy)',
        'images_legacy_comment' => 'Legacy image uploads from v1.x. Use the Items tab for new galleries.',
        'is_published' => 'Published',
        'updated_at' => 'Updated At',
        'published_at' => 'Published On',
        'date_filter' => 'Date',
        'album_tab' => 'Album Cover',
        'cover' => 'Cover',
    ],
    'gallery_items' => [
        'tab' => 'Gallery Items',
        'title' => 'Title',
        'type' => 'Type',
        'caption' => 'Caption',
        'image' => 'Image',
        'video_url' => 'Video URL',
        'video_url_comment' => 'YouTube or Vimeo URL (e.g. https://www.youtube.com/watch?v=...)',
        'video_thumb_url' => 'Video Thumbnail URL',
        'width' => 'Width',
        'height' => 'Height',
        'sort_order' => 'Sort Order',
        'dimensions_comment' => 'Auto-detected for images. Set manually for videos.',
    ],
    'components' => [
        'albums' => [
            'title' => 'Album List',
            'description' => 'Display a list of albums on the page.',
            'properties' => [
                'galleryPage' => 'Gallery Page',
                'galleryPage.description' => 'Name of the CMS page to link albums to.',
                'links' => 'Links',
                'sortBy' => [
                    'title' => 'Sort By',
                    'description' => 'Sort albums by this field.',
                    'options' => [
                        'title-asc' => 'Title Ascending',
                        'title-desc' => 'Title Descending',
                        'updated_at-asc' => 'Date modified Ascending',
                        'updated_at-desc' => 'Date modified Descending',
                        'published_at-asc' => 'Published On Ascending',
                        'published_at-desc' => 'Published On Descending',
                    ],
                ],
            ],
        ],
        'gallery' => [
            'title' => 'Gallery',
            'description' => 'Display a photo gallery with PhotoSwipe lightbox.',
            'not_found' => 'Gallery not found.',
            'properties' => [
                'source' => [
                    'title' => 'Gallery Source',
                    'description' => 'Load gallery by URL slug or select from dropdown.',
                ],
                'slug' => [
                    'title' => 'Slug',
                    'description' => 'URL slug parameter for the gallery.',
                ],
                'galleryId' => [
                    'title' => 'Gallery',
                    'description' => 'Select gallery from the list.',
                ],
                'layout' => [
                    'title' => 'Layout',
                    'description' => 'Gallery layout style. Overrides the gallery model setting.',
                ],
                'thumbWidth' => [
                    'title' => 'Thumbnail Width',
                ],
                'thumbHeight' => [
                    'title' => 'Thumbnail Height',
                ],
                'thumbMode' => [
                    'title' => 'Thumbnail Mode',
                ],
                'perPage' => [
                    'title' => 'Items Per Page',
                    'description' => 'Number of items per page (0 = show all, no pagination).',
                ],
                'loop' => [
                    'title' => 'Infinite Loop',
                ],
                'closeOnVerticalDrag' => [
                    'title' => 'Close On Vertical Drag',
                ],
                'escKey' => [
                    'title' => 'Close On Esc Key',
                ],
                'pinchToClose' => [
                    'title' => 'Pinch To Close',
                ],
                'zoom' => [
                    'title' => 'Zoom Button',
                ],
                'arrowEl' => [
                    'title' => 'Arrow Buttons',
                ],
                'counterEl' => [
                    'title' => 'Counter',
                ],
            ],
        ],
    ],
];

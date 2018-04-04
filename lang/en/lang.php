<?php return [
    'plugin' => [
        'name' => 'Photo Swipe',
        'description' => 'Plugin for create Photo Swipe Gallery.'
    ],
    'galleries' => [
        'backend_name'=>'Gallery',
        'title' => 'Title',
        'slug' => 'Slug',
        'description' => 'Description',
        'images' => 'Images',
        'is_published' => 'Published',
        'updated_at' => 'Updated At',
        'published_at' => 'Published On',
        'date_filter' => 'Date',
        'album_tab' => 'Album Cover',
        'cover' => 'Cover',
    ],
    'albums' => [
        'backend_name'=>'Albums',
        'title' => 'Title',
        'description' => 'Description',
        'cover' => 'Cover',
        'is_active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Modified At',
    ],
    'components' => [
        'albums' =>
            [
                'title' => 'Album List',
                'description' => 'Display a list of albums on the page.',
                'properties' => [
                    'galleryPage' => 'Gallery Page',
                    'links' => 'Links',
                    'sortBy' => [
                        'title' => 'Sort By',
                        'options' => [
                            'title-asc' => 'Title Ascending',
                            'title-desc' => 'Title Descending',
                            'updated_at-asc' => 'Date modified Ascending',
                            'updated_at-desc' => 'Date modified Descending',
                            'published_at-asc' => 'Published On Ascending',
                            'published_at-desc' => 'Published On Descending',
                        ]
                    ]
                ]
            ],
        'directGallery' =>
            [
                'title' => 'Images of Gallery',
                'description' => 'Show only images of gallery which is selected from dropdown properties.',
                'properties' => [
                    'gallery' => [
                        'title' => 'Gallery',
                        'description' => 'Select gallery you want to Add in your web page',
                    ]
                ]
            ],
        'viewGallery' =>
            [
                'title' => 'Gallery',
                'description' => 'Display images of Album as Swipe Gallery on the page.',
                'properties' => [
                    'slug' => [
                        'title' => 'Slug',
                        'description' => 'Enter your gallery slug to show images.',
                    ],
                    'showHideOpacity' => [
                        'title' => 'Show Animation',
                        'description' => 'Show animation when open and close gallery.',
                    ],
                    'loop' => [
                        'title' => 'Infinite Loop',
                        'description' => 'Infinite loop will continue after last item in list.',
                    ],
                    'closeOnScroll' => [
                        'title' => 'Close On Scroll',
                        'description' => 'Close gallery if mouse is scrolled.',
                    ],
                    'closeOnVerticalDrag' => [
                        'title' => 'Close On Vertical Drag',
                        'description' => 'Close gallery if image is dragged vertically.',
                    ],
                    'escKey' => [
                        'title' => 'Close On Esc Key',
                        'description' => 'Close gallery if Esc key is pressed.',
                    ],
                    'pinchToClose' => [
                        'title' => 'Pinch To CLose',
                        'description' => 'Do Pinch Gesture to Close gallery.',
                    ],
                    'captionEl' => [
                        'title' => 'Caption',
                        'description' => 'Want to show Caption on gallery?.',
                    ],
                    'swipeWhileZoom' => [
                        'title' => 'Swipe while Zoomed In',
                        'description' => 'Allow user to swipe while zoomed in.',
                    ],
                    'maxSpreadZoom' => [
                        'title' => 'Max Spread Zoom',
                        'description' => 'Allow maximum zooming.',
                    ],
                    'getDoubleTapZoom' => [
                        'title' => 'Double Tap Zoom level',
                        'description' => 'When Double tap/mouseClick default zoom level',
                    ],
                    'shareEl' => [
                        'title' => 'Share Button',
                        'description' => 'Want to show share button on gallery?',
                    ],
                    'zoomEl' => [
                        'title' => 'Zoom Button',
                        'description' => 'Want to show zoom button on gallery?',
                    ],
                    'fullscreenEl' => [
                        'title' => 'Fullscreen Button',
                        'description' => 'Want to show fullscreen button on gallery?',
                    ],
                    'arrowEl' => [
                        'title' => 'Arrows',
                        'description' => 'Want to show arrows on gallery?',
                    ],
                    'counterEl' => [
                        'title' => 'Counter on Screen',
                        'description' => 'Want to show counter(1 / 10) on gallery?',
                    ],
                ]
            ],
    ],
];
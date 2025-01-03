<?php

return [

    /*
     * The disk where files should be uploaded.
     */
    'disk' => 'public',

    /*
     * The queue used to perform image conversions.
     * Leave empty to use the default queue driver.
     */
    'queue' => null,

    'table' => 'media',

    /*
     * The fully qualified class name of the media model.
     */
    'model' => \App\Models\Media::class,

];

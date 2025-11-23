<?php

return [

    'browsershot' => [
        'node_binary'        => env('LARAVEL_PDF_NODE_BINARY'),
        'npm_binary'         => env('LARAVEL_PDF_NPM_BINARY'),
        'include_path'       => env('LARAVEL_PDF_INCLUDE_PATH'),
        'chrome_path'        => env('LARAVEL_PDF_CHROME_PATH'),
        'node_modules_path'  => env('LARAVEL_PDF_NODE_MODULES_PATH'),
        'bin_path'           => env('LARAVEL_PDF_BIN_PATH'),
        'temp_path'          => env('LARAVEL_PDF_TEMP_PATH'),
        'write_options_to_file' => env('LARAVEL_PDF_WRITE_OPTIONS_TO_FILE', false),
    ],

];

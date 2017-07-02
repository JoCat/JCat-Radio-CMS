<?php

return [
    // Temporary fix
    'news/view/(.*\w)' => 'error/not-found',
    'programs/view/(.*\w)' => 'error/not-found',
    'user/view/(.*\w)' => 'error/not-found',
    // End fix

    // Route
    'news/(\d+)-(.*\w)' => 'news/view/$1/$2',
    'programs/(.*\w)' => 'programs/view/$1',
    'user/(.*\w)' => 'user/view/$1'
];

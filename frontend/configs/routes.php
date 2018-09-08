<?php

return [
    'news/(\d+)-(.*\w)' => 'news/view/$1/$2',
    'programs/(.*\w)' => 'programs/view/$1',
    'user/(.*\w)' => 'user/view/$1'
];

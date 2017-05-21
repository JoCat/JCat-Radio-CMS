<?php
/**
 * 
 */
require_once __DIR__ . '/htmlpurifier/htmlpurifier_html5.php';

// EDIT: modify this to whatever you need.
$allowed = [
  'img[src|alt|title|width|height|style]',
  'figure', 'figcaption',
  'video[src|type|width|height|poster|preload|controls]', 'source[src|type]',
  'a[href|target]',
  'iframe[width|height|src|frameborder|allowfullscreen]',
  'strong', 'b', 'i', 'u', 'em', 'br', 'font',
  'h1[style]', 'h2[style]', 'h3[style]', 'h4[style]', 'h5[style]', 'h6[style]',
  'p[style]', 'div[style]', 'center', 'address[style]',
  'span[style]', 'pre[style]',
  'ul', 'ol', 'li',
  'table[width|height|border|style]', 'th[width|height|border|style]',
  'tr[width|height|border|style]', 'td[width|height|border|style]',
  'hr'
];

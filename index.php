<?php

$html = file_get_contents('index.html');

try {

    $seo = file_get_contents('seo.json');

    $seo = json_decode($seo, true);

    $rand_nav = $seo[array_rand($seo)];

    $examples = $rand_nav['examples'];

    $rand_example = $examples[array_rand($examples)];

    $classify = $rand_example['children'];

    $rand_classify = $classify[array_rand($classify)];

    $meta = $rand_classify['meta'] ?? [];

    if (isset($meta['title']))  $html = preg_replace('/<title>.*<\/title>/', '<title>' . $meta['title'] . '</title>', $html);

    else $html = preg_replace('/<title>.*<\/title>/', '<title>' . '开源三维' . date('Y/m/d/H') . '</title>', $html);

    if (isset($meta['keywords']))  $html = preg_replace('/<meta name="keywords" content=".*" \/>/', '<meta name="keywords" content="' . $meta['keywords'] . '" />', $html);

    if (isset($meta['description']))  $html = preg_replace('/<meta name="description" content=".*" \/>/', '<meta name="description" content="' . $meta['description'] . '" />', $html);

    echo $html;

} catch (Exception $e) {

    echo $html;
    
}

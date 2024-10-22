<?php

$html = file_get_contents('index.html');

try {
    $seo = json_decode(file_get_contents('seo.json'), true);

    if ($seo === null) {
        echo $html;
    }

    $rand_nav = $seo[array_rand($seo)];
    $examples = $rand_nav['examples'];
    $rand_example = $examples[array_rand($examples)];
    $classify = $rand_example['children'];
    $rand_classify = $classify[array_rand($classify)];
    $meta = $rand_classify['meta'] ?? [];

    $title = $meta['title'] ?? '开源三维' . date('Y/m/d/H');
    $keywords = $meta['keywords'] ?? '';
    $description = $meta['description'] ?? '';

    // 使用 htmlspecialchars 转义
    $title = htmlspecialchars($title, ENT_QUOTES);
    $keywords = htmlspecialchars($keywords, ENT_QUOTES);
    $description = htmlspecialchars($description, ENT_QUOTES);

    // 更新 HTML 内容
    if ($title) $html = preg_replace('/<title>.*<\/title>/', '<title>' . $title . '</title>', $html);
    else $html = preg_replace('/<title>.*<\/title>/', '<title>' . '开源三维' . date('Y/m/d/H') . '</title>', $html);
    if ($keywords) $html = preg_replace('/<meta name="keywords" content=".*" \/>/', '<meta name="keywords" content="' . $keywords . '" />', $html);
    if ($description) $html = preg_replace('/<meta name="description" content=".*" \/>/', '<meta name="description" content="' . $description . '" />', $html);

    // 添加结构化数据
    $structuredData = [
        "@context" => "http://threehub.cn",
        "@type" => "WebPage",
        "name" => $title,
        "description" => $description,
        "keywords" => $keywords
    ];
    $structuredDataScript = '<script type="application/ld+json">' . json_encode($structuredData, JSON_UNESCAPED_UNICODE) . '</script>';
    $html = str_replace('</head>', $structuredDataScript . '</head>', $html);

    echo $html;
} catch (Exception $e) {
    echo $html;
}

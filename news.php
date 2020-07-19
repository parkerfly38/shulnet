<?php

   

require "admin/sd-system/config.php";

$news = new news();

$changes = array();

if (! empty($_GET['id'])) {
    $article = $news->getArticle($_GET['id']);

    if (! empty($article['error'])) {
        header('Location: ' . PP_URL . '/login.php?code=L035');
        exit;
    }

    $article['meta_title'] = $article['title'];

    $template = new template('news_' . $article['type'], $article, '1');
} else {
    $template = new template('news', $changes, '1');
}

echo $template;
exit;
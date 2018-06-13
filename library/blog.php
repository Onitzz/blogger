<?php
// library/blog.php

/**
 * Return all articles.
 *
 * @param PDO $pdo
 * @return bool|PDOStatement
 */

function getArticles(PDO $pdo, $start = 0, $end = -1) {
    $limit = '';
    if($start >= 0 && $end > 0) {
        $limit = sprintf("LIMIT %d, %d",$start,$end);
    }
    $sql = 'SELECT 
                a.article_id, 
                a.title, 
                a.teaser,
                a.created_at,
                u.user_id,
                u.username,
                u.email, 
                GROUP_CONCAT(c.name) as categories 
            FROM article as a 
            JOIN article_has_category as ac 
              ON ac.article_id=a.article_id 
            JOIN category as c 
              ON ac.category_id = c.category_id
            JOIN user AS u
            ON a.user_id = u.user_id
            WHERE status=1 '.$limit.'
             GROUP BY a.article_id
          ORDER BY a.created_at';
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getUserArticle(PDO $pdo, $userId){
    $sql='SELECT 
            a.article_id, 
            a.title, 
            a.teaser,
            a.created_at,
            u.user_id,
            u.username,
            u.email,
            GROUP_CONCAT(c.name) as categories 
          FROM article as a 
          JOIN article_has_category as ac 
            ON ac.article_id=a.article_id 
          JOIN category as c 
            ON ac.category_id = c.category_id
          JOIN user AS u
            ON a.user_id = u.user_id 
          WHERE a.user_id = ?
          GROUP BY a.article_id
          ORDER BY a.created_at';
    $stmt = $pdo->prepare($sql);

    $articles= '';
    if($stmt->execute(array($userId))){
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    return $articles;
}

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
            LEFT JOIN article_has_category as ac 
              ON ac.article_id=a.article_id 
            LEFT JOIN category as c 
              ON ac.category_id = c.category_id
            JOIN user AS u
            ON a.user_id = u.user_id
            WHERE status=1 
             GROUP BY a.article_id
          ORDER BY a.created_at '.$limit;
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getUserArticle(PDO $pdo, $userId){
    $sql='SELECT 
            a.article_id, 
            a.title, 
            a.teaser,
            a.status,
            a.created_at,
            u.user_id,
            u.username,
            u.email,
            GROUP_CONCAT(c.name) as categories 
          FROM article as a 
          LEFT JOIN article_has_category as ac 
            ON ac.article_id=a.article_id 
          LEFT JOIN category as c 
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

function getCategories(PDO $pdo){
    $sql='SELECT *
          FROM category';

    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getArticle(PDO $pdo, $articleid){
    $sql = 'SELECT 
            a.article_id, 
            a.user_id,
            a.title, 
            a.teaser,
            a.status,
            a.content,
            a.created_at,
            GROUP_CONCAT(c.category_id) as categories 
          FROM article as a 
          LEFT JOIN article_has_category as ac 
            ON ac.article_id=a.article_id 
          LEFT JOIN category as c 
            ON ac.category_id = c.category_id
          WHERE a.article_id=?
          GROUP BY a.article_id
          ORDER BY a.created_at ';
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(array($articleid))) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return false;

}

function updateArticle(PDO $pdo, $articleid, $title, $teaser, $content, $status,$categories){
    $sql = "UPDATE article
            SET 
              `title`= ?,
              `teaser`= ?,
              `content`= ?,
              `updated_at`= ?,
              `status`= ?
            WHERE
              `article_id`= ?";
    $stmt = $pdo->prepare($sql);
    $now = date('Y-m-d H:i:s');
    $pdo->beginTransaction();

    try{
        $stmt->execute(array($title,$teaser,$content,$now,$status,$articleid));

        deleteCategoriesArticle($pdo,$articleid);
        addArticleCategories($pdo, $articleid, $categories );
        $pdo->commit();

        return $stmt->rowCount();
    }catch (PDOException $e){
        $pdo->rollBack();
    }

    return 0;


}

function deleteCategoriesArticle(PDO $pdo,$articleid){
    $sql='DELETE FROM article_has_category WHERE article_id=?';
    $stmt= $pdo->prepare($sql);

    if($stmt->execute(array($articleid))){
        return $stmt->rowCount();
    }
    return false;
}


function addArticle(PDO $pdo, $userid, $title, $teaser, $content, $status,$categories){
    $sql='INSERT INTO article(`user_id`,`title`,`teaser`,`content`,`created_at`,`updated_at`,`status`)
          VALUES(?,?,?,?,?,?,?)';

    $now = date('Y-m-d H:i:s');
    $pdo->beginTransaction();

    try{
        $stmt= $pdo->prepare($sql);
        $stmt->execute(array($userid,$title,$teaser,$content,$now,$now,$status));

        addArticleCategories($pdo, $pdo->lastInsertId(), $categories );
        $pdo->commit();

        return $stmt->rowCount();
    }catch (PDOException $e){
        $pdo->rollBack();
    }

    return 0;
}

function addArticleCategories(PDO $pdo, $articleid, $categories){
    $sql = 'INSERT INTO article_has_category(`article_id`,`category_id`) VALUES(?,?)';

    $cats= [] ;
    foreach ($categories as $category){
        if($category != 0){
            $stmt = $pdo->prepare($sql);
            $cats[] = $stmt->execute(array($articleid,$category));
        }
        else{
            $cats[] = 'no category';
        }
    }
    return $cats;
}

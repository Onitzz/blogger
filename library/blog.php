<?php
// library/blog.php

/**
 * Return all articles.
 *
 * @param PDO $pdo
 * @return bool|PDOStatement
 */
function getArticles(PDO $pdo) {
    $sql = 'SELECT * FROM article WHERE status=1';
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

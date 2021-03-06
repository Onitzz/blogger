<?php

require '../init.php';
require LIB_PATH . DS . 'user.php';


hasSession();

require LIB_PATH . DS . 'blog.php';
require LIB_PATH . DS . 'validator.php';

$errors = [];
$userid = $_SESSION['user']['user_id'];
$inputTitle = $_POST['title'] ?? null;
$teaser = $_POST['teaser'] ?? null;
$content = $_POST['content'] ?? null;
$inputCats = $_POST['categories'] ?? null;
$status = isset($_POST['publish']) ? 1 : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);



    if(validMinMax($inputTitle,5,150)){
        $errors[] = 'Le titre est incorrect';
    }

    if(validMinMax($teaser,5,800)){
        $errors[] = 'Le teaser est incorrect';
    }

    if(validMinMax($content,5,2500)){
        $errors[] = 'Le contenu est incorrect';
    }

    if(empty($errors)){
        $userid = strip_tags($userid);
        $inputTitle = strip_tags($inputTitle);
        $teaser = strip_tags($teaser);
        $content = strip_tags($content);
        $categories_clean= [];
        foreach ( $inputCats as $category){
            $categories_clean[] = strip_tags($category);
        }
        $article = addArticle($db,$userid,$inputTitle,$teaser,$content,$status,$categories_clean);
        if ($article) {
            header('Location: mes-articles.php');
        } else {
            $errors[] =  'un problem est survenue';
        }
    }


}

$categories = getCategories($db);
$title = "Ajouter un article";



include THEME_PATH . DS . 'blog/add-article.phtml';
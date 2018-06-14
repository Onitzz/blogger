<?php
require '../init.php';
require LIB_PATH . DS . 'user.php';


hasSession();

require LIB_PATH . DS . 'blog.php';
require LIB_PATH . DS . 'validator.php';

$errors = [];


$articleid=$_GET['id'];

$article = getArticle($db, $articleid);

$userid = $article['user_id'];
$inputTitle = $article['title'];
$teaser = $article['teaser'];
$content = $article['content'];
$inputCats = explode(',',$article['categories']);
$status = $article['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userid = $_SESSION['user']['user_id'];
    $inputTitle = $_POST['title'] ?? null;
    $teaser = $_POST['teaser'] ?? null;
    $content = $_POST['content'] ?? null;
    $inputCats = $_POST['categories'] ?? null;
    $status = isset($_POST['publish']) ? 1 : 0;
    $articleid = $_POST['articleid'] ?? null;

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
        $article = updateArticle($db,$articleid,$inputTitle,$teaser,$content,$status,$categories_clean);
        if ($article) {
            header('Location: mes-articles.php');
        } else {
            $errors[] =  'un probleme est survenue';
        }

    }


}

$categories = getCategories($db);
$title = "Modifier un article";



include THEME_PATH . DS . 'blog/add-article.phtml';
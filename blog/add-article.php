<?php include THEME_PATH . DS . 'header.phtml'; ?>
<?php include THEME_PATH . DS . 'navbar.phtml'; ?>

    <div class="container">
        <div class="row">
            <h1 class="col-md-3"><?= $title ?></h1>
            <button class="mb-2 mt-2 btn btn-success col-md-1 offset-md-8"><i class="fa fa-plus"></i>Ajouter</button>
        </div>

        <?php foreach ($articles as $article) : ?>
            <?php include THEME_PATH . DS . 'article.phtml'; ?>
        <?php endforeach; ?>

    </div>

<?php include THEME_PATH . DS . 'footer.phtml'; ?>
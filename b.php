<?php

$id = $_GET['id'];

if (!$id) {
    header('Location: /?err=noid');
    exit;
}

if (!preg_match('/^[0-9a-z-]*$/', $id)) {
    header('Location: /?err=badid');
    exit;
}

$post = 'posts/' . $id . '.php';
if (!file_exists($post)) {
    header('Location: /?err=nopost');
    exit;
}


require('common/head.php'); ?>

<div class="container blogpost mt-5 mb-5">
<?php require($post); ?>
</div>

<?php require('common/foot.php');

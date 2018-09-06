<?php

include '../../core/db_connect.php';

$getInput = filter_input_array(INPUT_GET);
$sql='SELECT * FROM posts WHERE id=?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$getInput['id']]);

$post=$stmt->fetch();


if(!empty($getInput['delete'])){

    $sql = 'DELETE FROM posts WHERE id=?';

    if($pdo->prepare($sql)->execute([
        $getInput['id']
    ])){
       header('LOCATION:/posts'); 
    }else{
        $message = 'Something bad happened';
    }
}

$content = <<<EOT
<h1>Delete Post</h1>
<p>
Are you sure you want to delete the post titled 
<strong>{$post['title']}</strong>?
</p>

<h4>
<a href="posts.php">No, take me back to saftey!</a>
</h4>

<br><br>
<div>
<a href="delete-post.php?id={$post['id']}&delete=true">Yes, delete the post</a>
</div>

EOT;

include '../../core/layout.php';
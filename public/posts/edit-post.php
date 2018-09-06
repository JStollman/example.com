<?php
include '../../core/db_connect.php';

$getInput = filter_input_array(INPUT_GET);
$sql='SELECT * FROM posts WHERE id=?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$getInput['id']]);


$post=$stmt->fetch();

$postInput = filter_input_array(INPUT_POST);
if (!empty($postInput)){

    $slug = preg_replace(
        "/[^a-z0-9-]+/",
        "-", strtolower($postInput['title'])
    );

    $sql = 'UPDATE posts SET title=?, slug=?, body=? WHERE id=?';
    if($pdo->prepare($sql)->execute([
        $postInput['title'],
        $slug,
        $postInput['body'],
        $postInput['id']
    ])){
        header('LOCATION:/posts');
    }else{var_dump('hi');
        $message = 'Something bad happened';
    }

}

$content = <<<EOT
<h1>Edit Post</h1>
<form method="post">

<input value="{$post['id']}" name="id" type="hidden">

<div class="form-control">
<label for="title">Title</label>
<input value="{$post['title']}" name="title" type="text">
</div>

<div class="form-control">
<label for="body">Body</label>
<textarea id="body" name="body" rows"8">{$post['body']}</textarea>
</div>

<div class="form-control">
<input type="submit" value="Submit Change">
</div>
</form>
<br></br>
<div>
<a href="delete-post.php?id={$post['id']}">DELETE</a>
</div>
EOT;

include '../../core/layout.php';
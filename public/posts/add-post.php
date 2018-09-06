<?php
include '../../core/db_connect.php';

$input = filter_input_array(INPUT_POST);
if (!empty($input)){

    $slug = preg_replace(
        "/[^a-z0-9-]+/",
        "-", strtolower($input['title'])
    );

    $sql = 'INSERT INTO posts SET id=uuid(), title=?, slug=?, body=?';
    if($pdo->prepare($sql)->execute([
        $input['title'],
        $slug,
        $input['body']
    ])){
        header('LOCATION:/posts');
    }else{var_dump('hi');
        $message = 'Something bad happened';
    }

}

$content = <<<EOT
<h1>Add a New Post</h1>
<form method="post">

<div class="form-control">
<label for="title">Title</label>
<input id="title" name="title" type="text">
</div>

<div class="form-control">
<label for="body">Body</label>
<textarea id="body" name="body"></textarea>
</div>

<div class="form-control">
<input type="submit" value="Submit">
</div>
</form>
EOT;

include '../../layout.php';
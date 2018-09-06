<?php
include '../../core/db_connect.php';

$input = filter_input_array(INPUT_GET);
$slug = preg_replace("/[^a-z0-9-]+/","-", strtolower($input['slug']));

$stmt = $pdo->prepare("SELECT * FROM posts WHERE slug= :slug" );
$stmt->execute(['slug'=>$slug]);

$row=$stmt->fetch();

$content = "<h1>{$row['title']}</h1>";
$content .= $row['body'];

$content.="<br><br><a href=\"edit-post.php?id={$row['id']}\">EDIT</a>";
$content.="<br><br><a href=\"delete-post.php?id={$row['id']}\">EDIT</a>";

include '../../core/layout.php';
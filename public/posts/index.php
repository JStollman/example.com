<?php
include '../../core/db_connect.php';
$stmt = $pdo->query('SELECT * FROM posts' );

$content='<h1>Blog Posts</h1>';
$content .= "<ul>";
while($row=$stmt->fetch()){
    $content .= "<li><a href=\"post.php?slug={$row['slug']}\">"
        . "{$row['title']}</a>";
}
$content .= "</ul>";

$content .= "<br></br>";
$content .= "<a href=\"add-post.php\">Add a Post</a>";



include '../../core/layout.php';
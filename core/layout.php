<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <meta name="decription" content="<?php echo $description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/dist/css/main.min.css" type="text/css">
  </head>
  <body>
    <header>
      <span class="logo">My Website</span>
      <a id="toggleMenu">Menu</a>
      <nav>
        <ul>
          <li><a href="/index.php">Home</a></li>
          <li><a href="/resume.php">Resume</a></li>
          <li><a href="/contact.php">Contact</a></li>
          <li><a href="/posts">Blog</a></li>
        </ul>
      </nav>
    </header>
    
    <?php echo $content; ?>


    <script>

        var toggleMenu = document.getElementById('toggleMenu');
        var nav = document.querySelector('nav');
        toggleMenu.addEventListener(
          'click',
          function(){
            if(nav.style.display=='block'){
              nav.style.display='none';
            }else{
              nav.style.display='block';
            }
          }
        );
  
      </script>
  </body>
</html>
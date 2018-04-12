<?php

require '../core/About/src/Validation/Validate.php';

$valid = new About\Validation\Validate();

$args = [
  'name'=>FILTER_SANITIZE_STRING,
  'email'=>FILTER_SANITIZE_EMAIL,
  'message'=>FILTER_SANITIZE_STRING,
  'subject'=>FILTER_SANITIZE_STRING,
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)) {
  

  $valid->validation = [
    'email'=>[[
      'rule'=>'email',
      'message'=>'Please enter a valid email'
    ],[
      'rule'=>'notEmpty',
      'message'=>'Please enter an email'
    ]],
    'name'=>[[
      'rule'=>'notEmpty',
      'message'=>'Please enter your name'
    ]],
    'message'=>[[
      'rule'=>'notEmpty',
      'message'=>'Please enter your message'
    ]]
    ];
  
    $valid->check($input);

    if (empty($valid->errors)) {


      require '../vendor/autoload.php';
      require '../../config.php';
      
      //use Mailgun\Mailgun;

      $mgclient = new Mailgun\Mailgun(MG_KEY);
      $domain = MG_DOMAIN;

      $result = $mgclient->sendMessage(
        $domain,
        [
          'from'=>"Mailgun Sandbox <postmaster@{$domain}>",
          'to'=>'Jason Stollman <Jason.Stollman@Gmail.com>',
          'subject'=>$input['subject'],
          'html'=>"<b>Name</b>: {$input['name']}<br><br>" .
            "<b>Email</b>: {$input['email']}<br><br>" .  
            "<b>Message</b><br>{$input['message']}"
        ]
      );

     header('LOCATION: thanks.html');
    }else{
      $message = "<div class=\"message-error\">The form has errors!</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Jason Snider</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/css/main.css" type="text/css">
  </head>
  <body>
    <header>
      <span class="logo">My Website</span>
      <a id="toggleMenu">Menu</a>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="resume.html">Resume</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </header>
    <main>

      <h1>Contact Jason Snider</h1>
      
      <?php echo (!empty($message)?$message:null); ?>

      <form action="contact.php" method="POST">
        
        <input type="hidden" name="subject" value="New submission!">
       
        
        <div>
          <label for="name">Name</label>
          <input id="name" type="text" name="name" value="<?php echo $valid->userInput('name'); ?>">
          <div class="message-error">
            <?php echo $valid->error('name'); ?>
        </div>

        <div>
          <label for="email">Email</label>
          <input id="email" type="text" name="email" value="<?php echo $valid->userInput('email'); ?>"> 
          <div class="message-error">
            <?php echo $valid->error('email'); ?>
          </div>
        </div>

        <div>
          <label for="message">Message</label>
          <textarea id="message" name="message"><?php echo $valid->userInput('message'); ?></textarea>
          <div class="message-error">
            <?php echo $valid->error('message'); ?>
          </div>
        </div>

        <div>
          <input type="submit" value="Send">
        </div>

      </form>
    </main>
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
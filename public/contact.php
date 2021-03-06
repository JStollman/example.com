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

     header('LOCATION: thanks.php');
    }else{
      $message = "<div class=\"message-error\">The form has errors!</div>";
    }
}

$pageTitle = "Contact-Jason Stollman"; 
$description = "Contact Jason Stollman";
$message = (!empty($message)?$message:null); 

$content = <<<EOT
<main>

<h1>Contact Jason Stollman</h1>
{$message}

<form action="contact.php" method="POST">
  
  <input type="hidden" name="subject" value="New submission!">
 
  
  <div>
    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{$valid->userInput('name')}">
    <div class="message-error">
      {$valid->error('name')}
  </div>

  <div>
    <label for="email">Email</label>
    <input id="email" type="text" name="email" value="{$valid->userInput('email')}"> 
    <div class="message-error">
      {$valid->error('email')}
    </div>
  </div>

  <div>
    <label for="message">Message</label>
    <textarea id="message" name="message">{$valid->userInput('message')}</textarea>
    <div class="message-error">
      {$valid->error('message')}
    </div>
  </div>

  <div>
    <input type="submit" value="Send">
  </div>

</form>
</main>
EOT;

require '../core/layout.php';
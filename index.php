<?php
// phpinfo();
?>
<html lang="en"><head>
    <meta charset="UTF-8">
    <title>Cable And Kits - Secret Message</title>
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/style.css"> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body translate="no">
  <div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Create Secret Message</a></li>
        <li class="tab"><a href="#login">Read Secret Message</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Create Secret Message</h1>
          
          <form action="" method="post" name="createMessageForm" id="createMessageForm">
          
          <div class="field-wrap">
            <label>
              Recipient Email <span class="req">*</span>
            </label>
            <input type="email" name="recipient_email" id="recipient_email" required="" autocomplete="off">
          </div>
          
          <div class="field-wrap">
            <label>
              Text<span class="req">*</span>
            </label>
            <textarea name="recipient_text" id="recipient_text" required="" autocomplete="off"></textarea>
          </div>
          
          <button type="submit" class="button button-block">Create</button>
          
          </form>


          <div id="response"></div>
        </div>
        
        <div id="login">   
          <h1>Read Secret Message</h1>
          
          <form action="/" method="post" name="readMessageForm" id="readMessageForm">
          
            <div class="field-wrap">
            <label>
              Recipient Key <span class="req">*</span>
            </label>
            <input type="text" required="" name="recipient_key" id="recipient_key" autocomplete="off">
          </div>
          
          
          <button class="button button-block">Read</button>
          
          </form>

          <div id="response2"></div>
        </div>
        
      </div>
    </div> 
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
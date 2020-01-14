<?php
    if(isset($_POST['email'])){
        mail('shuvashishpaul64@gmail.com','mysub','hello sagar');
    }
?>
<html>
  <head>
      <title>Mail</title>
  </head>
    <body>
        <form method="POST">
            <input type="submit" name="email" value="submit">
        </form>
    </body>
</html>

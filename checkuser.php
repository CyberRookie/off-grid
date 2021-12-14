<?php // Example 06: checkuser.php
  require_once 'db_inc.php';

  if (isset($_POST['user']))
  {
  //  $user   = sanitizeString($_POST['user']);
    $result = queryMysql("SELECT * FROM users WHERE user='$user'");

    if ($result->rowCount())
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "The username '$user' is taken</span>";
    else
      echo "<span class='available'>&nbsp;&#x2714; " .
           "The username '$user' is available</span>";
  }
?>

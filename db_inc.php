<?php // 12/5/21 Created for off-grid project
  $host = 'localhost';    // Change as necessary
  $data = 'off_grid';   // Change as necessary
  $user = 'root';   // Change as necessary
  $pass = 'steelers01';     // Change as necessary
  $chrs = 'utf8mb4';
  $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
  $opts =
  [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];
  
  try
  {
    $pdo = new PDO($attr, $user, $pass, $opts);
  }
  catch (PDOException $e)
  {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
  }
/* Commented out for now
  function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
  }
*/
  function queryMysql($query)
  {
    global $pdo;
    return $pdo->query($query);
  }

  function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
  }

  function createUser($user)
  {
    global $pdo;
  $stmt = $pdo->prepare("INSERT INTO `users` WHERE user='$user'");
  $stmt->execute();
  }
/* 12/7/21 Select all the users from DB

  $stmt = $pdo->prepare("SELECT * FROM `users`");
  $stmt->execute();
  $users = $stmt->fetchAll();

*/
/* Commented out for now
  function sanitizeString($var)
  {
    global $pdo;
    $var = strip_tags($var);
    $var = htmlentities($var);
   //Commented out! if (get_magic_quotes_gpc())
      $var = stripslashes($var);
    $result = $pdo->quote($var);          // This adds single quotes
    return str_replace("'", "", $result); // So now remove them
  }
*/
  function showProfile($user)
  {
    global $pdo;
    if (file_exists("$user.jpg"))
      echo "<img src='$user.jpg' style='float:left;'>";

    $result = $pdo->query("SELECT * FROM profiles WHERE user='$user'");

    while ($row = $result->fetch())
    {
      die(stripslashes($row['text']) . "<br style='clear:left;'><br>");
    }
    
    echo "<p>Nothing to see here, yet</p><br>";
  }
?>

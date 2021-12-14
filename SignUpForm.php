<!-- 12/7/21 Trying to set up the user login
including the database login file 
12/12/21 changed from require_once 'db_inc.php to Signup.php where the logic works
12/13/21 - Stripping all the php code out of the file and starting over, removed the 
require_once('login-signup/register.php');  file
-->
<?php
  require_once('./functions/Signup.php');
  if (isset($_POST) && count($_POST) > 0) {
        $Response = Signup($_POST);
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="styles/off-grid-theme.css">
</head>

<body>
    <section>
        <div class="container">
            <div class="user signinBx">
                <div class="imgBx">
               
                <img src="https://cdn.pixabay.com/photo/2021/11/23/13/32/forest-6818683_960_720.jpg" />
        <!--            <img src="https://cdn.pixabay.com/photo/2016/11/18/15/27/backpacker-1835353_640.jpg" />
        -->
                </div>
                <div class="formBx">
                    <form>
                        <h2>Sign Up</h2>
                       
                      <!-- 12/12/21 Adding code from register.php file for error messages
               -->
                        
                        <div class="input-container">
            <!-- Changing user login fields to match user database -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">     
                       
                            <i class="fa fa-user icon"></i>
                            <input type="text" name="full_name" class="input-field" id="full_name" placeholder="Full Name" required/>
                            <?php if (isset($Response['full_name']) && !empty($Response['full_name'])): ?>
            <!-- Bootstrap Alert -->
                            <small class="alert alert-danger alert-dismissable"><?php echo $Response
                            ['full_name']; ?></small>
                            <?php endif; ?>                          
                           
                        </div>

                        <div class="input-container">
                            <i class="fa fa-envelope icon"></i>
                            <input type="email" name="email" class="input-field" id="email" placeholder="Email" require/>
                            <?php if (isset($Response['email']) && !empty($Response['email'])): ?>
             <!-- Bootstrap Alert -->
                            <small class="alert alert-danger alert-dismissable"><?php echo $Response
                            ['email']; ?></small>
                            <?php endif; ?>                     
                        </div>

                        <div class="input-container">
                            <i class="fa fa-key icon"></i>
                            <input type="text" name="username" class="input-field" id="username" placeholder="Username" required/>
                            <?php if (isset($Response['username']) && !empty($Response['username'])): ?>
                            <small class="alert alert-danger alert-dismissable"><?php echo $Response
                            ['username']; ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="input-container">
                            <i class="fa fa-key icon"></i>
                            <input type="password" name="password" class="input-field" id="password" placeholder="User Password" required/>
                            <?php if (isset($Response['password']) && !empty($Response['password'])): ?>
                            <small class="alert alert-danger alert-dismissable"><?php echo $Response
                            ['password']; ?></small>
                            <?php endif; ?>
                        </div>

                        <?php if (isset($Response['error'])): ?>
     <!-- Bootstrap Alert -->
                        <div class="alert alert-danger alert-dismissable mb-3"><b>Oops</b>, <?php echo $Response
                        ['error']; ?></div>
                         <?php endif; ?>
                  <!-- 12/13/21 Commenting out for now 
                        <span id="message"></span>

                        <input type="submit" value="Create" onclick="return Validate()" />
                        -->   
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Sign Up</button>
                        </div>
                    <!--    
                        <p class="signup">
                            Already have an account?<a href="login.php" onclick="toggleForm();">
                      Sign In
                    </a>
                        </p>
                        -->
                    </form>
                </div>
            </div>
        </div>
    </section>
 <!-- 12/13/21 Commenting out
    <script src="validate.js" type="text/javascript" charset="utf-8"></script>
   
    <script src="signup.js" type="text/javascript" charset="utf-8"></script>
    -->
</body>

</html>
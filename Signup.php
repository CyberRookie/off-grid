<?php 
    // Hint!! When requiring files, I suggest using absolute file paths as this method tends to break things...
    //12/11/21 Modified  Signup fields for the users database in off-grid
    //require_once('./functions/Db.php');
    require_once('Db.php');

    /**
     * @param Array $data
     * @return Array 
     * @desc Receives an array containing our user information in an attempt to create a new user.
    */

    function Signup(array $data) 
    {
        $Data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        //Registration Data Filtering....
        $full_name = stripcslashes(strip_tags($Data['full_name']));
        $username = stripcslashes(strip_tags($Data['username']));
        $email = stripcslashes(strip_tags($Data['email']));
        $password = htmlspecialchars($Data['password']);
        //Just In Case....
        $Errors = [];

        if (preg_match('/[^A-Za-z0-9_]/', $full_name)) {
            $Errors['full_name'] = "Sorry, Please enter a valid first and last name";
        }

        if (preg_match('/[^A-Za-z0-9_]/', $username)) {
            $Errors['username'] = "Sorry, Please enter a valid user name";
        }

        //Check if the email exists...
        $emailExists = checkEmail($email);
        if ($emailExists['status']) {
            $Errors['email'] = "Sorry, This email already exist.";
        }

        if (strlen($password) < 7) {
            $Errors['password'] = "Sorry, Use a stronger password";
        }

        if (count($Errors) > 0) {           
            $Errors['error'] = "Please, correct the Errors in your form in order to continue.";
            return $Errors;
        } else {
            //Create the new user...
            $Data = [
                'full_name' => $full_name,
                'username' => $username,
                'email' => $email,
                'password' => $password
            ];
            $registration = Register($Data);
            
            if ($registration) {
                //Before the redirect this would be a good time to send a mail or something in order to verify the user...
                array_pop($Data);
                $_SESSION['current_session'] = [
                    'status' => 1,
                    'user' => $Data,
                    'date_time' => date('Y-m-d H:i:s'),
                ];
                //Changed redirect file from dashboard to Off-GridTemplate file
                header("Location: ../Off-GridTemplate.html");
            } else {
                //#You could probably notify the dev team within this line but this is just a demo still....
                $Errors['error'] = "Sorry an unexpected error and your account could not be created. Please try again later.";
                return $Errors;
            }
        }
    }

    /**
     * @param String $email
     * @return Array 
     * @desc Checks if an email string exists in the database and returns   an array which determines the output of the operation.
     */

    function checkEmail(string $email) : array
    {
        $dbHandler = DbHandler();
        $statement = $dbHandler->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $response['status'] = false;
            $response['data'] = [];
            return $response;
        }

        $response['status'] = true;
        $response['data'] = $result;
        return $response;
    }

    /**
     * @param Array $data
     * @return Array 
     * @desc Creates a new user and returns a boolean indicating the status of the operation...
     * 12/12/21 Taking out the created_at, updated_at from the register function.
     */
    function Register(array $data)
    {
        $dbHandler = DbHandler();
        $statement = $dbHandler->prepare("INSERT INTO `users` (full_name, username, email, password, status) VALUES (:full_name, :username, :email, :password, :status)");
        
        //#Defaults....
        $timestamps = date('Y-m-d H:i:s');
        $status = 1;
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        //Values Bindings....
        $statement->bindValue(':full_name', $data['full_name'], PDO::PARAM_STR);
        $statement->bindValue(':username', $data['username'], PDO::PARAM_STR);
        $statement->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $statement->bindValue(':password', $password, PDO::PARAM_STR);
        $statement->bindValue(':status', $status, PDO::PARAM_INT);
     //   $statement->bindValue(':created_at', $timestamps, PDO::PARAM_STR);
    //    $statement->bindValue(':updated_at', $timestamps, PDO::PARAM_STR);
        
        $result = $statement->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
?>
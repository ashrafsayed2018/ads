<?php 

class Code extends Core {
    function validate_code () {

        // check if there is cookies for temp code 
        if(isset($_COOKIE['temp_access_code'])) {

    
            // check if is set get email and is set get code 
    
            if(!isset($_GET['email']) && !isset($_GET['code'])) {
                
                header('Location:index');
            } else if (empty($_GET['email']) || empty($_GET['code'])) {
                header('Location:index');
            } else {
                // check if post code is set
    
                if(isset($_POST['code_submit'])) {
                    

                    $email = $_GET['email'];
                    $validation_code = $_POST['code'];

                
    
                    $sql = "SELECT * from users where validation_code = '$validation_code' and email = '$email'";
                    $result = $this->query($sql);

                    $row = $result->rowCount();
                    echo $row;
                    // check if the row count is == 1
    
                    if($result->rowCount() == 0) {
    
    
                        setcookie('temp_access_code', $validation_code, time() + 900);
    
                        header("Location:reset?email=$email&code=$validation_code");
    
                    } else {
                       // echo $this->set_messages("sorry worng validation code ");
                    }
                    
                }
            }
    
    
        }
        //  else {
    
        //    // set message 
    
        //    $this->set_messages("<p class='alert alert-danger text-center'> Sorry your validation code is wrong </p>");
    
        //    header('Location:recover');
        // }
    }
    
}
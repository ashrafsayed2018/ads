<?php 

class Code extends Core {
    function validate_code () {


     
        // check if there is cookies for temp code 
        if(isset($_COOKIE['temp_access_code'])) {

    
            // check if is set get email and is set get code 
    
            if(!isset($_GET['email']) && !isset($_GET['code'])) {
                
                $this->redirect('index');
            } else if (empty($_GET['email']) || empty($_GET['code'])) {
                $this->redirect('index');
            } else {
                // check if post code is set
    
                if(isset($_POST['code_submit'])) {
                  

                    $email = $_GET['email'];
                    $validation_code = $_GET['code'];


 
                    $sql = "SELECT * from users where validation_code = '$validation_code' and email = '$email'";
                    $result = $this->query($sql);
                    
                    $result->execute();

                    $row = $result->rowCount();
                 
                 
                    // check if the row count is == 1
    
                    if($row == 1) {
                        echo $_POST['code_submit'];
                        
                        
    
                        setcookie('temp_access_code', $validation_code, time() + 900);
    
                         $this->redirect("reset?email=$email&code=$validation_code");
                
    
                    } else {
                        echo $this->set_messages("ناسف رمز تفعيل خاطئ");
                        
                         $this->redirect('login');
                    }
                    
                }
            }
    
    
        }
         else {
    
            // set message 
    
            $this->set_messages("<p class='alert alert-danger text-center'> للاسف خطاء في زمز التفعيل  </p>");
    
            //  $this->redirect('recover');
        }
    }
    
}
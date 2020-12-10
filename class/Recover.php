<?php
class Recover extends Core {
    public function recover_password() {
        
            if($_SERVER['REQUEST_METHOD'] == "POST") {
        
                if(isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
                   // check if email exists 
        
                   $email = $_POST['email'];
        
                   if($this->email_exist($email)) {
                      // send email with the varification code 
        
                      $validation_code =  md5(uniqid(mt_rand(),true));
                      ;
        
                      setcookie('temp_access_code', $validation_code, time() + 300);
        
                      // updating the validatin code inside the users table where email = email
        
                      $sql = "UPDATE users set validation_code = '$validation_code' where email = '$email'";
                      $result = $this->query($sql);
                      if(!$result) {
                          echo "no updates";
                      }
        
                      $subject = "ashraf@gmail.com";
                      $msg     = "Here is your passowrd reset code
                      <strong style='color:green'>$validation_code</strong> 
                       Click her to reset  your password 
                       <a href='ads.local/code?email=$email&code=$validation_code'> click to rest your password </a>";
                   
        
                      $headers = "from : ashraf@e3lanat.com";
        
                     $this->send_email($email,$subject,$msg,$headers);
        
                      // set message 
        
                      $this->set_messages("<p class='alert alert-success text-center'> Please check your email or spam folder for a password reset </p>");
        
                    //    redirect('index.php');
        
        
                   } else {
                       $this->set_messages("<p class='alert alert-danger text-center'> this email   <strong>$email</strong> does not exists </p>");
                   } 
        
              
                } else {
                    header('Location:/');
                }
            }
        
            // if the user click on cancel button 
        
            if(isset($_POST['cancel_submit'])) {
                header('Location:login');
            }
        }
        
    
}
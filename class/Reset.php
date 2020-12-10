<?php 

class Reset extends Core {

    public function password_reset() {

        // check if there is cookies for temp code 
        if(isset($_COOKIE['temp_access_code'])) {
            if(isset($_GET['email']) && isset($_GET['code'])) {

                
    
    
                $email = $_GET['email'];
                $email = $email;
          
                    if(isset($_SESSION['token']) && isset($_POST['token'])) {
                
    
                        if($_POST['token'] == $_SESSION['token']) {

                          
    
                          $errors = [];
                            
                            $password = $_POST['password'];
                            $confirm_password = $_POST['confirm_password'];
                            if(mb_strlen($password) < 8) {
                              $errors[] = "الرقم السري يحب ان لا يقل عن 8 احرف";
                            }
                            if(!empty($password) && mb_strlen($password) > 7 && $password != $confirm_password) {
                                $errors[] = "الرقم السري غير متطابق";
                            }
    
                        // check if errors array is empty 
    
                        if(!empty($errors)) {
                            foreach($errors as $error) {
                                echo $this->validation_errors($error);
                            }
                        } else {
                            $updated_password = md5($password);

                            echo $updated_password;

                            
    
                            $sql = "UPDATE users SET password ='$updated_password',validation_code = 0, active = 1  WHERE email='$email'";
    
                            $result = $this->query($sql);

                            $result->execute();
                          
    
                            $this->set_messages("<p class='alert alert-success text-center' > تم تحديث الرقم السري الرجاء تسجيل الدخول </p>");
    
                            //  header('location:login');
    
    
                        }
    
                        }
                        
                    }
                }
        } else {
    
            $this->set_messages("<p class='alert alert-danger text-center' > ناسف اعد ارسال الايميل مره اخرى</p>");
    
            //  header('location:recover');
        }
    }
   

}
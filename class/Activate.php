<?php

class Activate extends Core {
 
public function activate_user() {

    if($_SERVER['REQUEST_METHOD'] == 'GET') {


        if(isset($_GET['email']) && $_GET['code']) {

           $email = $_GET['email'];
           $validation_code = $_GET['code'];
       
           
           // check if we have a row in the database 

           $sql = "SELECT id from users where email = '$email' and validation_code='$validation_code'";

           $result = $this->conn->prepare($sql);
           $result->execute();
           $rowCount = $result->rowCount();

           if($rowCount == 1) {
               // upadte the active state in users table to 1 

               $sql2 = "UPDATE users set validation_code = 0 , active = 1 where email = '$email' and validation_code = '$validation_code'";

               $result2 = $this->conn->prepare($sql2);
               $result2->execute();


              $this->set_messages("<p class='alert alert-success text-center'> تم تفعيل حسابك على موقع روجلى يمكنك الدخول للحساب </p>");
              
            $this->redirect('login');
              
         
           } else {
                 $this->set_messages("<p class='alert alert-danger text-center'> للاسف لم يتم تفعيل حسابك تحقق من الرابط في بريدك الالكتروني مره اخري !!! </p>");

                 $this->redirect('register');

           }
        }
    }
}
}
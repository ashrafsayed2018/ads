<?php require_once 'header.php'; ?>

	<!-- <div class="landing-page"></div> -->
	<div id="container">
		<div class="row">
			<div class="col-lg-6" style="margin: 0 auto">
				<div class="text-center text-success">تسجيل دخول</div>
               
                    <div class="form">
                   
                        <form class="register-form" method="POST">
              
          
                            <input class="input" type="email" name="email" value="<?php echo $ob->formValue('email');?>" placeholder="البريد الالكتروني" required>
                     
                            <input class="input" type="text" name="name" value="<?php echo $ob->formValue('name');?>" placeholder="الاسم" required>
               

               
                            <input class="input" type="password" name="password" value="<?php echo $ob->formValue('password');?>" placeholder="الرقم السري">
                   
                            <input class="input" type="password" name="cpassword" value="<?php echo $ob->formValue('cpassword');?>" placeholder="تأكيد الرقم السري ">
                
                            <button type="submit" name="signup"> تسجيل  </button>
                            <p class="message">لديك حساب بالفعل <a href="/login">دخول </a></p>
                     </form>
                </div>
            </div>
        </div>
    </div>
        
<?php require_once "footer.php"; ?>
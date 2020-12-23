<?php require_once 'header.php'; ?>

	<div id="container">
		<div class="row">
			<div class="col-lg-6" style="margin: 0 auto">
            <?php echo $ob->display_message(); ?>
				<div class="text-center text-info">تسجيل دخول</div>
               
                    <div class="form">
                   
                        <form class="register-form" method="POST">
              
          
                            <input class="input" type="email" name="email" value="<?php echo $ob->formValue('email');?>" placeholder="البريد الالكتروني" required>
                     
                            <input class="input" type="text" name="username" value="<?php echo $ob->formValue('username');?>" placeholder="الاسم" required autocomplete="on">
               

                            <div class='password'>
                                <input class="input" type="password" name="password" value="<?php echo $ob->formValue('password');?>" placeholder="الرقم السري"  autocomplete="new-password">
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                         
                            <div class='password'>
                                <input class="input" type="password" name="cpassword" value="<?php echo $ob->formValue('cpassword');?>" placeholder="تأكيد الرقم السري " autocomplete="new-password">
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                
                            <button type="submit" name="signup"> تسجيل  </button>
                            <p class="message">لديك حساب بالفعل <a href="/login">دخول </a></p>
                     </form>
                </div>
            </div>
        </div>
    </div>
        
<?php require_once "footer.php"; ?>
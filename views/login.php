<?php require 'header.php'; ?>

	
	<div id="container">
		<div class="row">
            <div class="col-lg-6" style="margin: 50px auto">

					<?php

						echo $ob->display_message();
					
						
						if(isset($_GET['forget'])){
							?>
					<div class="heading text-center" style="margin: 20px auto">الرجاء قم بتسجيل البريد الالكتروني المسجل في الموقع سابقا</div>
					<?php 
                  
					?>
					<form action="" method="POST">
						<?php

							$ob->display_message();
						?>
						<input class="input form-control" type="email" name="email" value="" placeholder="Email">
						<input type="hidden" name="token" value="<?php echo  $ob->token_generator();?>">
						<button type="submit" class="btn btn-success" name="forget"> تغيير الرقم السري </button>
					</form>
							<?php
						}
						else{
							?>
					<h2 class="text-center text-info mb-2">دخول</h2>
						<?php
							if(isset($ob->data['error']) && !empty($ob->data['error'])){
								foreach ($ob->data['error'] as $error) {
									echo '<div class="text-danger text-center">: '.$error.'</div>';
								}
							}
						?>
                        <form class="login-form" action="" method="POST" class="mb-5">
                   
                       <input class="input" type="text" name="email" value="<?php echo $ob->formValue('email');?>" placeholder="البريد الالكتروني">
					   <div class="password">
							<input class="input" type="password" name="password" value="<?php echo $ob->formValue('password');?>" placeholder="الرقم السري" required autocomplete="new-password">
							<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					   </div>
						<a href="/login/?forget=1"> نسيت الرقم السري ؟ </a> <br><br>
						<button type="submit" name="login"> دخول </button>
                        <p class="message">ليس لديك حساب ؟ <a href="/register">تسجيل حساب </a></p>
                        </form>
							<?php
						}
                    ?>
             </div>
        </div>
	
	</div>
	
<?php require_once "footer.php";?>
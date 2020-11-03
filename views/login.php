<?php require 'header.php'; ?>

	
	<div id="container">
		<div class="row">
            <div class="col">
					<?php
						if(isset($_GET['forget'])){
							?>
					<div class="heading">نسيت الرقم السري</div>
					<form action="" method="POST">
						<?php
							if(isset($ob->data['error']) && !empty($ob->data['error'])){
								foreach ($ob->data['error'] as $error) {
									echo '<div style="color:#FFF;padding:5px">'.$error.'</div>';
								}
							}
						?>
						<input class="input" type="email" name="email" value="" placeholder="Email">
						<button type="submit" name="forget"> تغيير الرقم السري </button>
					</form>
							<?php
						}
						else{
							?>
					<div class="text-center text-success mb-5">دخول</div>
						<?php
							if(isset($ob->data['error']) && !empty($ob->data['error'])){
								foreach ($ob->data['error'] as $error) {
									echo '<div style="color:#FFF;padding:5px">ERROR: '.$error.'</div>';
								}
							}
						?>
                        <form class="login-form" action="" method="POST" class="mb-5">
                        <?php
							if(isset($ob->data['error']) && !empty($ob->data['error'])){
								foreach ($ob->data['error'] as $error) {
									echo '<div style="color:#FFF;padding:5px">ERROR: '.$error.'</div>';
								}
							}
						?>
                       <input class="input" type="text" name="email" value="" placeholder="البريد الالكتروني">
						<input class="input" type="password" name="password" value="" placeholder="الرقم السري" required>
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
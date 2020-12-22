<?php 
require_once "header.php";
?>
	<div class="row">
	    <div class="col">
			<div class="alert-placeholder">
					  <?php 
					  $ob->display_message();
					  $ob->password_reset();
					 
					   ?>
	        </div>
	   </div>
	</div>
    	<div class="row">
			<div class="col-md-6" style="margin: 0 auto ">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
						
							<div class="col-xs-12">
								<h3 class="text-center">تغيير الرقم السري الخاص بحسابك</h3>

							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="register-form" method="post" role="form" >

									<div class="form-group">
									     <div class="password">
											<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="الرقم السري" >
											<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
										 </div>
									</div>
									<div class="form-group">
										<div class="password">
											<input type="password" name="confirm_password" id="confirm-password" tabindex="2" class="form-control" placeholder="تأكيد الرقم السري" >
											<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
										</div>
									</div>
									<div class="form-group">
									<input type="hidden" class="hide" name="token" id="token" value="<?php echo $ob->token_generator()?>">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="reset-password-submit" id="reset-password-submit" tabindex="4" class="form-control btn btn-success" value="تغيير الرقم السري">
											</div>
										</div>
									
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php require_once "footer.php"; ?>

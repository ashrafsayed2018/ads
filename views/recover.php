<?php 
require_once "header.php";
?>
    <div class="row">
				<div class="col-lg-6 col-md-6" style="margin: 0 auto">
					<div class="alert-placeholder">
					  <?php 
					
						$ob->display_message();
						$ob->recover_password();
					
					 
					   ?>
					</div>
					<div class="panel panel-success">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="text-center"><h2><b>Recover Password</b></h2></div>
									<form id="register-form"  method="post" role="form" autocomplete="off">
										<div class="form-group">
											<label for="email">Email Address</label>
											<input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="" autocomplete="on" />
										</div>
										<div class="form-group">
											<div class="row">

												<div class="col-lg-6 col-sm-6 col-xs-6">
													<input type="submit" name="cancel_submit" id="cencel-submit" tabindex="2" class="form-control btn btn-danger" value="Cancel" />
												</div>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<input type="submit" name="recover-submit" id="recover-submit" tabindex="2" class="form-control btn btn-success" value="Send Password Reset Link" />
												</div>

												
											</div>
										</div>
										<input type="hidden" class="hide" name="token" id="token" value="<?php echo $ob->token_generator()?>">
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/script.js"></script>
</body>
</html>
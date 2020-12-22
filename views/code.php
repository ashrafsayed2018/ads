<?php 
require_once "header.php";
?>
	<div class="row">
		<div class="col-lg-6" style="margin: 0 auto">	
		
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">×</span><span class="sr-only">Close</span>
				</button> الرجاء قم بالضغط على المتابعه لتغيير الرقم السري
			</div>					
		</div>
	</div>

    <div class="row">
				<div class="col-lg-6" style="margin: 0 auto">
					<div class="alert-placeholder">
						<?php 
						//  $ob->display_message();
						  $ob->validate_code ();

					
						?>
					</div>
					<div class="panel panel-success">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="text-center"><h2><b> تم ادخال الكود اضغط على زر متابعه  </b></h2></div>
									<form id="register-form"  action="" method="post" role="form" autocomplete="off">
										<div class="form-group">
											<input type="text" name="code" id="code" tabindex="1" class="form-control" disabled value="<?php echo $_GET['code']; ?>" autocomplete="off" required/>
										</div>
										<div class="form-group">
											<div class="row">

												<div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-xs-6">
													<input type="submit" name="code_submit" id="recover-submit" tabindex="2" class="form-control btn btn-success" value="متابعه" />
													
												</div>

												
												<div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2  col-xs-6">
													<input type="submit" name="code-cancel" id="code-cancel" tabindex="2" class="form-control btn btn-danger" value="الغاء" />
			
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
			<?php 
require_once "footer.php";
?>
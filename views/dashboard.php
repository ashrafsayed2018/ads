<?php require_once 'header.php';

?>

<div class="container">
   <div class="row">
       <div class="col col-md-8">

        <?php
	             echo $ob->display_message();

							if(isset($_GET['edit-profile'])){

								 
							?>
							<div class="form" >
							<form action="" method="POST" enctype="multipart/form-data" class="profile-form">
									<div class="group">
										
										<input type="email" name="email" placeholder="Email" value="<?php echo $ob->data['user']['email'];?>" class="input">
									</div>
									<div class="group">
									
										<input type="text" name="username" placeholder="الاسم " value="<?php echo $ob->data['user']['username'];?>" class="input" >
									</div>
									يمكنك ترك الحقول فارغه اذا اردت عدم تغييرها
									<div class="group">
										
										<input type="file" name="picture" accept="image/*" placeholder="Picture" class="input" style="font-size:11px;border-bottom:0px;" >
									</div>
									<div class="group">
										
										<input type="password" name="opassword" placeholder="الرقم السري القديم" class="input" >
									</div>
									<div class="group">
										
										<input type="password" name="npassword" placeholder="الرقم السري الجديد" class="input" >
									</div>
									<div class="group">
										
										<input type="password" name="cpassword" placeholder=" تأكيد الرقم السري الجديد" class="input" >
									</div>
									<button type="submit">تحديث</button>
								</form>
							</div>

							<?php
							}
							else if(isset($_GET['ad-edit'])){
							?>
							<div class="form">
								<form action="" method="POST" class="ad-form" 	enctype="multipart/form-data">

										<h4 style="text-align:center">تفاصيل الاعلان  </h4><br>
										<div class="group">
											<input type="text" name="title" placeholder="عنوان الاعلان ( يحب ان لايقل عن 10 حروف ولا يزيد عن 40 حرف )" value="<?php echo $ob->formValue('title'); ?>" class="input" required>

										</div>
										<div class="group">
											
											<select id="category" name="category" class="input form-control" style="font-size:14.1px;" required>
											<option value="">الفئه</option>
						
												<?php
													$cate = $ob->getCategories();
													while($category = $cate->fetch(PDO::FETCH_ASSOC)){

														if($ob->formValue('category') == $category['id']) {
															echo "<option value='" .$category['id']."' selected>".$category['name']."</option>";
														} else {
															echo "<option value='" .$category['id']."'>".$category['name']."</option>";
														}
												
													}
												?>
											</select>
										</div>
								
										<div class="group">

										<label for="images" class="text-center form-control">اضافة صوره مسموح باربعة صور على الاكثر</label>
											<input type="file" name="images[]" placeholder="الصور" class="input" style="font-size:11px;border-bottom:0px;" multiple="multiple" value="" id="images">

										</div>
										<div class="group">
										<?php
											if(isset($_SESSION['images'])) {
												$images = $_SESSION['images'];
												foreach ($images as $image) {
													echo '
													
														<span style="display:inline-block;width:80px"><img src="'.$image.'" style="width: 100%;
														height: 60px;"></span>
													';
													}

											}
										
										?>
										</div>
										<textarea name="description" placeholder="وصف الاعلان ( يحب ان لايقل عن 50 حرف ولا يزيد عن 400 حرف )" class="input form-control " style="height:300px;resize:none" required><?php echo $ob->formValue('description');?></textarea>
										<div class="group" >
										
											<input type="text" name="mobile" value="<?php echo $ob->formValue('mobile');?>" placeholder="رقم الجوال" class="input" required>
										</div>
									
										<div class="group">
										
											<select name="location" class="input form-control" style="font-size:14.1px;" required>
											<option value="">المنطقه</option>
												<?php
													$ob->loadCities();
												?>
											</select>
										</div>
										<button type="submit"><?php echo ($_GET['ad-edit'] == 0)? 'نشر' : 'تحديث';?> </button>
								</form>
							</div>

							<?php
							}
							else{

								if($ob->data['user']['admin'] == 1){
							?>
							<table class="table">
							     <td>
								 	<a href="?dashboard=1&list=pending"><div class="dashbox">تحت المراجعه [<?php echo $ob->getCount('0');?>]</div></a>
								 </td>
							     <td>
									 <a href="?dashboard=1&list=approved"><div class="dashbox">تم الموافقه عليه [<?php echo $ob->getCount();?>]</div></a>
								  </td>
			
							</table>
							<?php
								}
							?>
							<table class="table" cellspacing="0">
								<tr>
									<th>مسلسل</th>
									<th>العنوان</th>
									<th>الحاله</th>
									<th>Action</th>
								</tr>
							<?php
								if($ob->data['list']!=''){
									while($ads = $ob->data['list']->fetch(PDO::FETCH_ASSOC)){
										$status = ($ads['status']==0)?'تحت المراجعه':'مفعل';
										echo '
										<tr>
										<td style="width:5%">'.$ads['id'].'</td>
										<td style="width:50%">'.$ads['title'].'</td>
										<td style="width:5%">'.$status.'</td>
										<td style="width:40%"> ';
										 if(isset($_GET['list'])) {
										if($ob->data['user']['admin'] == 1 && $_GET['list'] =='pending')
											echo '<a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'" class="btn btn-primary">عرض</a>
											 <a href="?ad-approve='.$ads['id'].'" class="btn btn-success">قبول </a>
											  <a href="?delete-ad='.$ads['id'].'" class="btn btn-danger">رفض</a>';
										else
										echo '<a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'" class="btn btn-primary text-light">عرض</a> <a href="?ad-edit='.$ads['id'].'" class="btn btn-success text-light">تعديل </a> <a href="?delete-ad='.$ads['id'].'" class="btn btn-danger text-light">حذف</a>';
										echo '
										</td>
										</tr>
										';
										 }
									}
								}
								else{
									echo '
									<tr>
									<td colspan="4" style="width:100%">لا  توجد اعلانات تحت المراجعه</td>
									</tr>';
								}
							?>
							</table>
							<?php
							}
							?>
							
        </div>
		<div class="col-12 col-md-4">
                    <div class="profile block"> <!-- PROFILE (MIDDLE-CONTAINER) -->
              
                        <div class="profile-picture big-profile-picture clear">
                            <img width="150px" alt="<?php echo $ob->data['user']['username'];?>" src="<?php echo $ob->data['user']['dp'];?>" >
                        </div>
                        <strong class="user-name"><?php echo $ob->data['user']['username'];?></strong>
                        <ul class="profile-options horizontal-list">
                            <li>
								<a class="comments" href="?dashboard">
									<p>لوحة التحكم</p>
								</a>
							</li>
                            <li>
								  <?php 
								  
							    //if($ob->data['user']['admin'] == 1){
								
								?>
								<a class="views" href="?ad-edit=0"> 
								<P> اعلان جديد</P>
								</a>

								<?php 
								// } else { 
									
									?>

								<!-- <a class="views" href="?ad-edit=1">
								 <P>  تحديث الاعلان</P>
								</a> -->
								<?php // }?>
							 </li>
                            <li>
									<a class="likes" href="?edit-profile=1">
										<p> تحديث الملف  </p>
									</a>
							 </li>
                        </ul>
                    </div>
                </div>
    </div>
</div>


<?php require_once 'footer.php'; ?>

<script type="text/javascript">
	$(document).ready(function(){
		//navigation scroll function
		$(window).scroll(function(){
		    if($(this).scrollTop()>=50){
		        $("nav").css({"background-color":"#FFF"});
		    }
		    else{
		    	$("nav").css({"background-color":"rgba(255, 255, 255, 0.1)"});
		    }
		});
		
	});
</script>
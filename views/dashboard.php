<?php require_once 'header.php'; ?>

<div class="container">
   <div class="row">
       <div class="col col-md-8">

        <?php
							if(isset($_GET['edit-profile'])){
							?>
							<div class="form" >
							<form action="" method="POST" enctype="multipart/form-data" class="profile-form">
									<div class="group">
										
										<input type="email" name="email" placeholder="Email" value="<?php echo $ob->data['user']['email'];?>" class="input">
									</div>
									<div class="group">
									
										<input type="text" name="name" placeholder="Name" value="<?php echo $ob->data['user']['name'];?>" class="input">
									</div>
									يمكنك ترك الحقول فارغه اذا اردت عدم تغييرها
									<div class="group">
										
										<input type="file" name="picture" accept="image/*" placeholder="Picture" class="input" style="font-size:11px;border-bottom:0px;">
									</div>
									<div class="group">
										
										<input type="password" name="opassword" placeholder="الرقم السري الحالي" class="input">
									</div>
									<div class="group">
										
										<input type="password" name="npassword" placeholder="الرقم السري الجديد" class="input">
									</div>
									<div class="group">
										
										<input type="password" name="cpassword" placeholder="تأكيد الرقم السري" class="input">
									</div>
									<button type="submit">تحديث</button>
								</form>
							</div>

							<?php
							}
							else if(isset($_GET['ad-edit'])){
								// $spec = $ob->loadSpecification();
								// $feature = $ob->loadFeature();
							?>
							<div class="form">
								<form action="" method="POST" class="profile-form" 	enctype="multipart/form-data">

									<?php
										if(isset($ob->data['error']) && !empty($ob->data['error'])){
											foreach ($ob->data['error'] as $error) {
												echo '<div style="color:#00FF00;padding:5px">'.$error.'</div>';
											}
										}
									?>

										<strong>تفاصيل الاعلان : </strong><br>
										<div class="group">
											<input type="text" name="title" placeholder="العنوان" value="<?php echo (isset($ob->data['ad']['title']))?$ob->data['ad']['title']:'';?>" class="input" required>

										</div>
										<div class="group">
											
											<select id="category" name="category" class="input form-control" style="font-size:14.1px;">
												<?php
													$cate = $ob->getCategories();
													while($category = $cate->fetch(PDO::FETCH_ASSOC)){
														if(isset($ob->data['ad']['cat_id']) && $category['id']==$ob->data['ad']['cat_id'])
															echo '<option value="'.$category['id'].'" selected>'.$category['name'].'</option>';
														else
															echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
													}
												?>
											</select>
										</div>
										<div class="group">
											
											<input type="number" name="price" placeholder="السعر" value="<?php echo (isset($ob->data['ad']['price']))?$ob->data['ad']['price']:'';?>" step="10" class="input" required>
											
										</div>
										<div class="group">
											<input type="file" name="images[]" placeholder="الصور" class="input" style="font-size:11px;border-bottom:0px;" multiple="multiple">

										</div>
										<textarea name="description" placeholder="الوصف" class="input form-control"><?php echo (isset($ob->data['ad']['description']))?$ob->data['ad']['description']:'';?></textarea>
										<div class="group">
											
											<input type="text" name="mobile" value="<?php echo (isset($ob->data['ad']['mobile']))?$ob->data['ad']['mobile']:'';?>" placeholder="رقم الموبايل" class="input" required>
										</div>
										<div class="group">
											
											<input type="text" name="address" value="<?php echo (isset($ob->data['ad']['address']))?$ob->data['ad']['address']:'';?>" placeholder="العنوان" class="input" required>
										</div>
										<div class="group">
										
											<select name="location" class="input form-control" style="font-size:14.1px;">
												<?php
													$ob->loadCities();
												?>
											</select>
										</div>
										<button type="submit"><?php echo ($_GET['ad-edit'] == 0)? 'نشر' : 'تحديث';?> الاعلان</button>
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
                            <img width="150px" alt="<?php echo $ob->data['user']['name'];?>" src="<?php echo $ob->data['user']['dp'];?>" >
                        </div>
                        <h1 class="user-name"><?php echo $ob->data['user']['name'];?></h1>
                        <ul class="profile-options horizontal-list">
                            <li>
								<a class="comments" href="?dashboard">
									<p>لوحة التحكم</p>
								</a>
							</li>
                            <li>
								  <?php 
								  
							    if($ob->data['user']['admin'] == 1){
								?>
								<a class="views" href="?ad-edit=0"> <P> اعلان جديد</P></a>
								<?php } else { ?>
								<a class="views" href="?ad-edit=1"> <P>  تحديث الاعلان</P></a>
								<?php }?>
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
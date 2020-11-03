<?php
//SORTING CITIES AFTER ADDING NEW CITY
/*function sortCities(){
	$json = json_decode(file_get_contents('assets/cities.json'),true);
		ksort($json);
		foreach($json as $key => $value) {
			asort($json[$key]);
			$json[$key] = array_values($json[$key]);
		}
	file_put_contents('assets/cities.json',json_encode($json));
}*/
?>
<?php require 'header.php'; ?>
	<div class="adViewer">
		<div id="container">
			<table>
				<tr>
					<td class="v-align-t" style="width:70%;color:#000;"> 
						<div class="ad-content">
							<?php
							if(isset($_GET['edit-profile'])){
							?>
								<form action="" method="POST" enctype="multipart/form-data" class="dash-form">
									<div class="group">
										
										<input type="email" name="email" placeholder="Email" value="<?php echo $ob->data['user']['email'];?>" class="input">
										<div class="label">الايميل  </div>
									</div>
									<div class="group">
									
										<input type="text" name="name" placeholder="Name" value="<?php echo $ob->data['user']['name'];?>" class="input">
										<div class="label">الاسم </div>
									</div>
									يمكنك ترك الحقول فارغه اذا اردت عدم تغييرها
									<div class="group">
										
										<input type="file" name="picture" accept="image/*" placeholder="Picture" class="input" style="font-size:11px;border-bottom:0px;">
										<span class="label">صورة الملف الشخصي</span>
									</div>
									<div class="group">
										
										<input type="password" name="opassword" placeholder="الرقم السري الحالي" class="input">
										<div class="label">  الرقم السري الحالي</div>
									</div>
									<div class="group">
										
										<input type="password" name="npassword" placeholder="الرقم السري الجديد" class="input">
										<div class="label">الرقم السري الجديد </div>
									</div>
									<div class="group">
										
										<input type="password" name="cpassword" placeholder="تأكيد الرقم السري" class="input">
										<div class="label">تأكيد الرقم السري </div>
									</div>
									<button type="submit">تحديث</button>
								</form>
							<?php
							}
							else if(isset($_GET['ad-edit'])){
								// $spec = $ob->loadSpecification();
								// $feature = $ob->loadFeature();
							?>
								<form action="" method="POST" class="dash-form" enctype="multipart/form-data">

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
										<div class="label">العنوان </div>

									</div>
									<div class="group">
										
										<select id="category" name="category" class="input" style="font-size:14.1px;">
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
										<div class="label">الاقسام </div>
									</div>

									<!-- <div>
										المواصفات  <br>
										<div id="specification"></div>
									</div>


									<div style="padding:10px;">
										المزايا <br>
										<div id="features"></div>
									</div> -->
									<div class="group">
										
										<input type="number" name="price" placeholder="السعر" value="<?php echo (isset($ob->data['ad']['price']))?$ob->data['ad']['price']:'';?>" step="10" class="input" required>
										<span class="label">السعر</span>
										
									</div>
									<div class="group">
										<input type="file" name="images[]" placeholder="الصور" class="input" style="font-size:11px;border-bottom:0px;" multiple="multiple">
										<span class="label">الصور</span>

									</div>
									<textarea name="description" placeholder="الوصف" class="input"><?php echo (isset($ob->data['ad']['description']))?$ob->data['ad']['description']:'';?></textarea>
									<strong>تفاصيل البائع </strong><br>
									<div class="group">
										
										<input type="text" name="mobile" value="<?php echo (isset($ob->data['ad']['mobile']))?$ob->data['ad']['mobile']:'';?>" placeholder="رقم الموبايل" class="input" required>
										<div class="label">رقم الموبايل </div>
									</div>
									<div class="group">
										
										<input type="text" name="address" value="<?php echo (isset($ob->data['ad']['address']))?$ob->data['ad']['address']:'';?>" placeholder="العنوان" class="input" required>
										<div class="label">العنوان </div>
									</div>
									<div class="group">
									
										<select name="location" class="input" style="font-size:14.1px;">
											<?php
												$ob->loadCities();
											?>
										</select>
										<div class="label">المنطقه </div>
									</div>
									<button type="submit"><?php echo ($_GET['ad-edit']== 0)? 'نشر' : 'تحديث';?> الاعلان</button>
								</form>

<script type="text/javascript">
	$(document).ready(function(){

		// var specification = '<?php echo (!empty($spec))?json_encode($spec):'';?>';
		// var feature = '<?php echo (!empty($spec))?json_encode($feature):'';?>';
		// feature = $.parseJSON(feature);
		// specification = $.parseJSON(specification);
		// $('#category').on('change',function(){
		// 	loadfeature();
		// 	loadspec();
		// });

		// <?php 
		// if($_GET['ad-edit'] !='0'){
		// ?>
		// var edit = 1;
		// var tempfeature = $.parseJSON('<?php echo (isset($ob->data['ad']['feature']))?$ob->data['ad']['feature']:'';?>');
		// var temp = $.parseJSON('<?php echo (isset($ob->data['ad']['specification']))?$ob->data['ad']['specification']:'';?>');
		// <?php
		// }
		// else{
		// ?>
		// var edit = 0;
		// <?php
		// }
		// ?>
		// loadspec();
		// loadfeature();
		// function loadfeature(){
		// 	//console.log(tempfeature);
		// 	if(feature!=''){
		// 		category = $('#category option:selected').html();
		// 		$('#features').html('');
		// 		$.each(feature[category], function (key,val) {
		// 			if(edit==1 && jQuery.inArray(val, tempfeature) !== -1)
		// 				$('#features').append('<input type="checkbox" name="features[]" value="'+val+'" checked> '+val+'&nbsp;&nbsp;');
		// 			else
		// 				$('#features').append('<input type="checkbox" name="features[]" value="'+val+'"> '+val+'&nbsp;&nbsp;');
		// 		});
		// 	}
		// }
		// function loadspec(){
		// 	//console.log(tempfeature);
		// 	if(specification!=''){
		// 		category = $('#category option:selected').html();
		// 		$('#specification').html('');
		// 		$.each(specification[category], function (key,val) {
		// 			if(edit==1 && temp[val])
		// 				$('#specification').append('<div class="group"><input type="text" name="spec['+val+']" value="'+temp[val]+'" class="input"><div class="label">'+val+' </div></div>');
		// 			else
		// 				$('#specification').append('<div class="group"><input type="text" name="spec['+val+']" class="input"><div class="label">'+val+' </div></div>');
		// 		});
		// 	}
		// }
		
	});
</script>

							<?php
							}
							else{
								if($ob->data['user']['admin']==1){
							?>
							<center>
								<a href="?dashboard=1&list=pending"><div class="dashbox">تحت المراجعه [<?php echo $ob->getCount('0');?>]</div></a>
								<a href="?dashboard=1&list=approved"><div class="dashbox">تم الموافقه عليه [<?php echo $ob->getCount();?>]</div></a>
								<a href="?dashboard"><div class="dashbox">المالك</div></a>
							</center>
							<?php
								}
							?>
							<table class="ad-list" cellspacing="0">
								<tr>
									<th>مسلسل</th>
									<th>العنوان</th>
									<th>الحاله</th>
									<th>Action</th>
								</tr>
							<?php
								if($ob->data['list']!=''){
									while($ads = $ob->data['list']->fetch(PDO::FETCH_ASSOC)){
										$status = ($ads['status']==0)?'Pending':'Active';
										echo '
										<tr>
										<td style="width:5%">'.$ads['id'].'</td>
										<td style="width:50%">'.$ads['title'].'</td>
										<td style="width:5%">'.$status.'</td>
										<td style="width:40%"> ';
										 if(isset($_GET['list'])) {
										if($ob->data['user']['admin'] == 1 && $_GET['list'] =='pending')
											echo '<a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'">View ad</a> <a href="?ad-approve='.$ads['id'].'">Approve</a> <a href="?delete-ad='.$ads['id'].'">Decline</a>';
										else
										echo '<a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'">View ad</a> <a href="?ad-edit='.$ads['id'].'">Edit ad</a> <a href="?delete-ad='.$ads['id'].'">Delete</a>';
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
					</td>
					<td class="v-align-t">
						<div class="ad-content">
							<div class="dp"><img src="<?php echo $ob->data['user']['dp'];?>"></div>
							<div class="seller-name"><?php echo $ob->data['user']['name'];?></div>
							<ul class="menu">
								<li><a href="?dashboard">لوحة التحكم</a></li>
								<li><a href="?ad-edit=0">عمل اعلان جديد</a></li>
								<li><a href="?edit-profile=1">تحديث الملف الشخصي</a></li>
							</ul>
						</div>
						
					</td>
				</tr>
			</table>

		</div>
	</div>

<?php require 'footer.php'; ?>

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
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php echo $ob->sitename; ?>
	</title>
<link rel="stylesheet" type="text/css" href="/assets/preloader.css" />
<link rel="stylesheet" type="text/css" href="/assets/theme.css" />
<script src="/assets/jquery.js"></script>
</head>
<body>
	<div class="preloader">
		<div class="dot-container">
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
		</div>
	</div>
	<!--NAVBAR HERE-->
	<?php require 'navigation.php'; ?>

	<div class="landing-page"></div>
	<div id="container" style="margin-top:150px">
		<div class="table">
			<div class="table-cell w-50 v-align-t">
				<div class="slogans">
					<h1>موقع سوقلى </h1>
					<h2>  اشتري وبيع واعلن عن كل شئ</h2>
					<div class="slogan3">بيع -اشتري - خدمات - اشياء حديثه - اشياء قديمه </div>
					<a href="/dashboard/?ad-edit=0"><div class="postAds"><span>اعلان</span> جديد</div></a>
				</div>
			</div>
			<div class="table-cell w-50 v-align-m">
				<div class="top-form-wrapper">
					<div class="heading">ايحث عن ؟ </div>
					<form action="/search/1" method="POST">
						<input class="input" type="text" name="query" value="" placeholder="ابحث عن ؟">
						<select name="category">
							
							<?php
							echo '<option value="">اختر فئه</option>';
								$cate = $ob->getCategories();
								
									while($category = $cate->fetch(PDO::FETCH_ASSOC)){
										echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
									}
							?>
						</select>
						<select name="location">
							<?php
								$ob->loadCities();
							?>
						</select>
						<button type="submit"> بحث </button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="category">
			<div class="box-container">
			<?php
				$cat = $ob->getCategories();
				if(!empty($cat)){
					while($c = $cat->fetch(PDO::FETCH_ASSOC)){
						echo '
						<a href="/list/'.$c['id'].'">
							<div class="box">
								<div class="text-panel">
									<img src="'.$c['icon'].'">
									'.$c['name'].'
									<div class="ads">['.$ob->getAdCount($c['id']).']</div>
								</div>
							</div>
						</a>
						';
					}
				}
			?>
			</div>
			
		</div>

		<div id="container" style="padding-top: 100px;">
			<div class="head-title">احدث الاعلانات</div>
			<div class="ads-wrapper-container">
				<div class="ads-wrapper">

				<?php
					if(!empty($ob->latestAd())){
						$query = $ob->latestAd();
						while($ads = $query->fetch(PDO::FETCH_ASSOC)){
							$thumb = json_decode($ads['images'])[0];
							echo '
								<div class="ad-container ad-hidden">
									<div class="thumb">
										<div class="img">
											<a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'"><img src="'.$thumb.'"></a>
										</div>
										<a href="/all-ads/'.$ads['user_id'].'"><img src="'.$ob->user2dp($ads['user_id']).'" class="seller-dp"></a>
									</div>
									<div class="type"> 
										<a href="/list/'.$ads['cat_id'].'">'.$ob->cat_id2name($ads['cat_id']).'</a>
									</div>
									<a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'"><div class="title">'.$ads['title'].'</div></a>
									<div class="address"><img src="/assets/icons/location.svg" class="icon-small"> '.$ads['address'].' </div>
									<div class="price">₹​ '. number_format($ads['price'],2,'.',',') .' /-</div>
								</div>
							';
						}
					}
				?>

				</div>
			</div>
		</div>
	</div>

	<div class="footer">
		<a href="">سياسة الخصوصيه</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="">شروط الاستخدام</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="">المدونه</a>
	</div>
	<div class="reserve">جميع الحقوق محفوظه <?php echo date('Y'); ?> </div>
	
</body>
</html>
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
		//ads loading animation on scroll
		function apperance(_this,i) {
		    setTimeout(function() { 
		    	$(_this).removeClass("ad-hidden"); 
		    }, 100 + i * 300);
		}

		$(window).scroll(function(){
			var scrTop = $(this).scrollTop()+$(this).height();
			$(".ad-hidden").each(function(index){
				if(scrTop > $(this).offset().top){
					apperance(this,index);
				}
		    });
		});
	});
	$(window).on("load", function(){
		//$(".preloader").fadeOut("slow");
		setTimeout(function(){ 
			$(".preloader").fadeOut("slow");
			$(".landing-page").addClass("bg-animation");
			$(".top-form-wrapper").addClass("form-animation");
			$(".slogans h1").addClass("slogan-h1-animation");
			$(".slogans h2").addClass("slogan-h2-animation");
		}, 1000);
	});
</script>
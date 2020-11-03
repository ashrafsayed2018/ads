<?php require 'header.php'; 
$ad = $ob->data['ad'];
$ob->incView($ad['id']);
?>

	<div class="adViewer">
		<div id="container">

			<div class="table">
				<div class="table-cell v-align-m" style="width:80%">
					<div class="adname"><?php echo $ad['title'];?></div>
				</div>
				<div class="table-cell v-align-m h-align-r" style="text-align:right;">
					<div class="price-holder">
						<div class="currency">&#8377</div>
						<div class="price"> <?php echo $ad['price'];?> </div>
					</div>
				</div>
			</div>

			<div class="bottom-border"></div>

			<div>
				<div class="inline-content"> <span>&#128336;</span> التاريخ : <?php echo date('d - M - Y',strtotime($ad['dt']));?></div> <div class="inline-content"> <span>&#128065;</span> المشاهدات <?php echo $ad['views'];?></div> <div class="inline-content"> <span>&#128278;</span> رقم الاعلان <?php echo $ad['id'];?></div>  <div class="inline-content"> <div class="categoryname"><?php echo $ob->getCat($ad['cat_id']);?></div> </div> 
			</div>

			<div class="thumbnail-container">
				<div class="thumbnail-content">
					<?php
						$images = json_decode($ad['images']);
						foreach ($images as $image) {
							echo '<a target="_blank" href="'.$image.'"><img src="'.$image.'"></a>';
						}
					?>
				</div>
			</div>

			<table>
				<tr>
					<td class="v-align-t" style="width:70%;"> 
						<div class="ad-content">
							<!-- <div class="spec-container">
								<?php
									// $spec = json_decode($ad['specification']);
									// if(!empty($spec)) {
									// 	foreach ($spec as $key => $value){
									// 		echo '<div class="spec"> '.$key.' : '.$value.'</div>';
									// 	}
									// }
									
									
								?>
							</div>
							<div class="feature-container">
								<div class="title">الميزات </div>
								<ul>
								<?php
									// $feature = json_decode($ad['feature']);
									// foreach ($feature as $value){
									// 	echo '<li><i>&#10004;</i> '.$value.'</li>';
									// }
								?>
								</ul>
							</div> -->
							<div class="contact-info">
								<div class="title"> معلومات الاتصال</div>
								<ul>
									<li>
										<div class="title">الموبايل </div> <div class="span">965 <?php echo $ad['mobile'];?> </div>
									</li>
									<li>
										<div class="title">العنوان  </div> <div class="span"> <?php echo $ad['address'];?> </div>
									</li>
								</ul>
							</div>
							<div class="description">
								<div class="title"> الوصف  </div>
								<?php echo $ad['description'];?>
							</div>
						</div>



<div class="content" style="padding:0;margin:0;">
		<div id="container" style="padding-top: 100px;">
			<div class="head-title">احدث الاعلانات </div>
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
									<div class="type"> <a href="/list/'.$ads['cat_id'].'">'.$ob->cat_id2name($ads['cat_id']).'</a></div>
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


					</td>
					<td class="v-align-t">
						<div class="ad-content">
							<div class="dp"><img src="<?php echo $ob->user2dp($ad['user_id']);?>"></div>
							<div class="seller-name"><?php echo $ob->user_id2name($ad['user_id']);?></div>
							<a href="/all-ads/<?php echo $ad['user_id']; ?>"><div class="view-all-ad">عرض كل الاعلانات </div></a>
							<div class="phn-holder">
								<div class="icon">&#9742;</div>
								<div class="number"> 965 <?php echo $ad['mobile'];?> </div>
							</div>
						</div>
						<div class="ad-content">
						<?php
							$cat = $ob->getCategories();
							if(!empty($cat)){
								while($c = $cat->fetch(PDO::FETCH_ASSOC)){
									echo '
									<a href="/list/'.$c['id'].'">
										<div class="box">
												<img src="'.$c['icon'].'">
												'.$c['name'].'
												<div class="ads">['.$ob->getAdCount($c['id']).']</div>
										</div>
									</a>
									';
								}
							}
						?>
						</div>
					</td>
				</tr>
			</table>

		</div>
	</div>



	
           <!-- start footer -->
           <footer class="footer">
                <div class="container">
                  <div class="row">
                      <div class="col-12 col-md-6">
                          <div class="app-info">
                             <h3 class="text-center">انت على اكبر موقع تسويق في الكويت</h3>
                          </div>
                      </div>
                      <div class="col-12 col-md-2">
                        <div class="user-info">
                           <h3 class="text-center">حسابي</h3>
                            <ul class="list-unstyled text-center">
                                <li>الاعلانات الخاصه بي </li>
                                <li> خريطة الموقع </li>
                            </ul>
                        </div>
                      </div>
                      <div class="col-12 col-md-2">
                        <div class="privacy-info">
                          <h3 class="text-center">معلومات</h3>
                          <ul class="list-unstyled text-center">
                            <li>عنا </li>
                            <li> الشروط والاحكام </li>
                            <li>  سياسة الخصوصيه </li>
                            <li>  سياسة ملف التعريف </li>
                            <li>المدونه </li>
                           </ul>
                        </div>
                      </div>
                      <div class="col-12 col-md-2">
                        <div class="contact-info">
                          <h3 class="text-center"> معلومات الاتصال</h3>
                          <ul class="list-unstyled text-center">
                            <li>اتصل بنا </li>
                           </ul>
                        </div>
                    </div>
                  </div>
                  <div class="row">
  
                    <div class="col-12 col-md-6">
                        <div class="social-accounts">
                            <ul class="list-unstyled text-center">
                              <li><i class="fa fa-instagram"></i></li>
                              <li><i class="fa fa-facebook"></i></li>
                              <li><i class="fa fa-snapchat"></i></li>

                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                      <div class="copyright text-center">جميع الحقوق محفوظه لموقع سوقلي شكرا &copy; <span class="copy-year">2020</span> &reg;</div>
                    </div>

                  </div>
                </div>
            </footer>
            <!-- end footer -->
      <!-- end the main content -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- <script src="../assets/script.js"></script> -->
    <script>
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
</body>
</html>

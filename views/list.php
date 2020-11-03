<?php require_once 'header.php'; ?>

<div class="container">
    <div class="row">
         <div class="col">
             <ul class="list-inline bg-secondary pt-2 pb-2">
                <li class="list-inline-item"><a href="?orderby=date" <?php echo (!isset($_GET['orderby']) || $_GET['orderby']=='date') ? 'class="active"' : '' ;?>>التاريخ</a></li>
				<li class="list-inline-item"><a href="?orderby=title" <?php echo (isset($_GET['orderby']) && $_GET['orderby']=='title') ? 'class="active"' : '' ;?>>العنوان</a></li>
				<li class="list-inline-item"><a href="?orderby=price" <?php echo (isset($_GET['orderby']) && $_GET['orderby']=='price') ? 'class="active"' : '' ;?>>السعر</a></li>
				<li class="list-inline-item"><span>رتب حسب</span></li>
             </ul>
         </div>
    </div>
           <div class="row">
					<?php
					if(!empty($ob->display())){
						$query = $ob->display();
						while($ads = $query->fetch(PDO::FETCH_ASSOC)){
							$thumb = json_decode($ads['images'])[0];
							echo '
                            <div class="col-12 col-md-4 ad-hidden">
                            <div class="ad-container">
                              <div class="thumb">
                                <div class="img">
                                  <a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'">
                                      <img src="'.$thumb.'">
                                  </a>
                                </div>
                                <a href="/all-ads/'.$ads['user_id'].'">
                                  <img src="'.$ob->user2dp($ads['user_id']).'" class="seller-dp">
                                </a>
                              </div>
                              <div class="type"> 
                                  <a href="/list/'.$ads['cat_id'].'">'.$ob->cat_id2name($ads['cat_id']).'</a>
                              </div>
                              <a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'">
                                  <div class="title">'.substr($ads['title'],0,20).'</div>
                              </a>
                              <div class="description">'.substr($ads['description'],0,50). ' ...</div>
                              <div class="date-like d-flex justify-content-between align-content-center">
                                <div class="date">'.$ads['dt'].'</div>
                                <div class="like"> <i class="fa fa-heart"></i></div>
                              </div>
                            </div>
                        </div>
							';
						}
					}
					else{
						echo '<h3 style="color:#66a80f;">لا توجد اعلانات لهذا البحث </h3>';
					}
				?>
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
		//ads loading animation on scroll
		function apperance(_this,i) {
		    setTimeout(function() { 
		    	$(_this).removeClass("ad-hidden"); 
		    }, 100 + i * 300);
		}

		function checkLoad(){
			var scrTop = $(this).scrollTop()+$(this).height();
			$(".ad-hidden").each(function(index){
				if(scrTop > $(this).offset().top){
					apperance(this,index);
				}
		    });
		}

		checkLoad();

		$(window).scroll(function(){
			checkLoad();
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
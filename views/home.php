<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $ob->sitename; ?> </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/preloader.css" />

    <link rel="stylesheet" href="../assets/style.css">
 
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


      <!-- start the main content  -->
      <main>
         
            <!-- start the site header -->
              <header class="main-header pt-5">
              <div class="landing-page"></div>
                <div class="container">
               

                    <div class="slogans">
                        <h1>موقع سوقلى </h1>
                        <h2>  اشتري وبيع واعلن عن كل شئ</h2>
                        <div class="slogan3">بيع -اشتري - خدمات - اشياء حديثه - اشياء قديمه </div>
                        <a href="/dashboard/?ad-edit=0"><div class="postAds"><span>اعلان</span> جديد</div></a>
                    </div>
                    <div class="top-form-wrapper mt-5">
                      <form action="/search/1" method="POST">
                          <div class="form-row">
                            <div class="col-12 col-md-6 mb-2">
                              <input type="text" name="query" class="form-control" placeholder="ابحث">
                            </div>
                            <div class="col-12 col-md-2 mb-2">
                              <select name="category" id="select" class="form-control">
                                <?php
                                    $cate = $ob->getCategories();
                                    
                                        while($category = $cate->fetch(PDO::FETCH_ASSOC)){
                                            echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                                        }
                                    ?>
                              </select>
                            </div>
                            <div class="col-12 col-md-2 mb-2">
                              <input type="text" class="form-control" placeholder="المدينه">
                            </div>
                            <div class="col-12 col-md-2 mb-2">
                              <input type="submit" class="form-control btn btn-primary" value="بحث">
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
              </header>
            <!-- end the site header  -->

            <!-- start feature ads section -->
            <div class="container">
              <section class="feature-ads mt-5 mb-5">
                <!-- start ad card  -->
                <h2 class="text-center">اعلانات مميزه</h2>
            
                  <div id="adFeatureCarousel">
                      
				<?php
					if(!empty($ob->latestAd())){
						$query = $ob->latestAd();
						while($ads = $query->fetch(PDO::FETCH_ASSOC)){
							$thumb = json_decode($ads['images'])[0];
							echo '
                            <div class="gallery-cell">
                                <a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'">
                                    <img src="'.$thumb.'">
                            
                                    <div class="feature-categoryLike d-flex justify-content-between">
                                    <a href="/list/'.$ads['cat_id'].'">
                                        <div class="categoryName ">'.$ob->cat_id2name($ads['cat_id']).'</div>
                                    </a>
                                    <div class="like">
                                        <i class="fa fa-heart"></i>
                                    </div>
                                    </div>
                                    <div class="feature-ad-details ">
                                        <a href="/view/'.$ads['id'].'/'.urlencode($ads['title']).'">
                                            <p>'.substr($ads['title'],0,20).'</p>
                                        </a>
                                        <p>'.substr($ads['description'],0,50). ' ... </p>
                                    </div>
                                    <div class="feature-date-author d-flex justify-content-between">
                                        <div class="date">'.$ads['dt'].'</div>
                                        <a href="/all-ads/'.$ads['user_id'].'">
                                            <div class="author"> '.$ob->user_id2name($ads['user_id']).'</div>
                                        </a>
                                    </div>
                                </a>
                            </div>
							';
						}
					}
				?>
                    <!-- <div class="gallery-cell">
                      <img src="https://raw.githubusercontent.com/rexxars/react-hexagon/HEAD/logo/react-hexagon.png" />
                      <div class="feature-categoryLike d-flex justify-content-between">
                           <div class="categoryName ">سيارات</div>
                           <div class="like">
                             <i class="fa fa-heart"></i>
                           </div>
                      </div>
                      <div class="feature-ad-details ">
                          <h4>افخم سياره في امبابه</h4>
                          <p>افخم سياره في امبابه افخم سياره في امبابه افخم سياره في امبابه افخم سياره في امبابه افخم سياره</p>
                      </div>
                      <div class="feature-date-author d-flex justify-content-between">
                           <div class="date">22-10-2020</div>
                            <div class="author">اشرف سيد</div>
                      </div>
                    </div>
                     -->

                </div>
          </section>

            </div>
    
            <!--start  popular categories -->
            <section class="popular-categories mt-5 mb-5">
             <div class="container">
               <h2 class="text-center">التصنيفات الرائجه </h2>
               <div class="row">
               <?php
				$cat = $ob->getCategories();
				if(!empty($cat)){
					while($c = $cat->fetch(PDO::FETCH_ASSOC)){
						echo '
						
                            <div class="col-4 col-md-2">
                            <a href="/list/'.$c['id'].'">
                                <div class="category" style="height: 10rem;">
                                <img class="category-img-top" src="'.$c['icon'].'" alt="'.$c['name'].'">
                                <div class="category-body">
                                    <h5 class="category-title text-center">'.$c['name'].'</h5>
                                    <p class="category-count text-center">'.$ob->getAdCount($c['id']).'</p>
                                </div>
                                </div>
                            </a>
                         </div>
					
						';
					}
				}
			?>
                
                </div>

             </div>
            </section>
            <!-- end popular categories -->
            <!-- start latest ads  -->

            <section class="latest-ads mt-5 mb-5">
              <div class="container">
                 <h2 class="text-center">احدث الاعلانات</h2>

                <div class="row">
                <?php
					if(!empty($ob->latestAd())){
						$query = $ob->latestAd();
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
				?>
             
                </div>
              </div>
            </section>

            <!-- end latest ads  -->

       
         
      </main>

    <?php require_once "footer.php"; ?>
  
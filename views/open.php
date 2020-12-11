<?php require 'header.php'; 
$ad = $ob->data['ad'];
$ob->incView($ad['id']);
?>

        <div class="container">
          <div class="row">
                <div class="col-sm-12">
                      <table class="table">
                        <tr>
                           <td>
                              <span class="adDate">
                                  <span>&#128336;</span> التاريخ : <?php echo date('Y - m - d ');?>
                              </span>
                           </td>
                           <td>
                              <span class="adtitle">
                                العنوان
                                    <?php echo $ad['title'];?>
                              </span>
                           </td>
                           <td>
                              <span class="adViews">
                                  <span>&#128065;</span> المشاهدات <?php echo $ad['views'];?>
                              </span>
                           </td>
                           <td>
                           <span class="adAuthor"></span>
                           </td> 
                           <td>
                               <span class="addNumber">
                                      <span>&#128278;</span> رقم الاعلان <?php echo $ad['id'];?>
                               </span>
                           </td>
                           <td>
                                <span class="btn btn-outline-primary">
                                     التصنيف
                                        <?php echo $ob->getCat($ad['cat_id']);?>
                                </span>
                           </td>
                        </tr>
                      </table>
                </div>
                <div class="col-sm-12">
                    <div id="adFeatureCarousel">
                          <?php
                            $images = json_decode($ad['images']);
                            foreach ($images as $image) {
                              echo '
                              <div class="">
                                  <a target="_blank" href="'.$image.'"><img src="'.$image.'" style="display: inline-block;
                                  width: 480px;
                                  height: 380px;"></a>
                              </div>';
                            }
                          ?>
                         

                         
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="profile">
                                <p class="text-right"> معلومات الاتصال </p>
                                <ul class="list-unstyled text-right pr-3 pl-3">
                                  <li>
                                    <span class="">رقم المعلن : </span>
                                     <a class="btn btn-danger text-light" href="tel:<?php echo $ad['mobile' ];?> "> <?php echo $ad['mobile' ];?> 
                                  </a>
                                  </li>
                                  <li>
                                    <span class="text-right">العنوان :</span> 
                                    <span class="span"> <?php echo $ad['location'];?> </span>
                                  </li>
                                </ul>
                              <div class="description text-right">
                                <div class="text-right"  style="padding: 1rem"> الوصف  </div>
                                <p style="padding: 1rem">
                                <?php echo $ad['description'];?>
                                </p>
                              </div>
                    </div>
                </div>
                <!-- <div class="col-12 col-md-4">
                    <div class="ad-content">
                        <div class="dp"><img src="<?php echo $ob->user2dp($ad['user_id']);?>"></div>
                        <div class="seller-name"><?php echo $ob->user_id2name($ad['user_id']);?></div>
                        <a href="/all-ads/<?php echo $ad['user_id']; ?>"><div class="view-all-ad">عرض كل الاعلانات </div></a>
                        <div class="phn-holder">
                          <div class="icon">&#9742;</div>
                          <div class="number"> 965 <?php echo $ad['mobile'];?> </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-12 col-md-4">
                    <div class="profile block"> <!-- PROFILE (MIDDLE-CONTAINER) -->
              
                        <div class="profile-picture big-profile-picture clear">
                            <img width="150px" alt="Anne Hathaway picture" src="<?php echo $ob->user2dp($ad['user_id']);?>" >
                        </div>
                        <h1 class="user-name"><?php echo $ob->user_id2name($ad['user_id']);?></h1>
                        <div class="profile-description">
                            <a href="/all-ads/<?php echo $ad['user_id']; ?>" class="scnd-font-color">عرض كل الاعلانات</a>
                        </div>
                        <ul class="profile-options horizontal-list">
                            <li>
                              <a class="comments" href="#40">
                                <p><i class="fa fa-comment-o scnd-font-color"></i>  
                                23
                                </p>
                              </a>
                            </li>
                            <li>
                              <a class="views" href="#41">
                                <p>
                                  <I class="fa fa-eye scnd-font-color"></I> 
                                  <?php echo $ad['views'];?>
                                  </p>
                                </a>
                            </li>
                            <li>
                                <a class="likes" href="#42">
                                  <p>
                                    <I class="fa fa-heart scnd-font-color">	</I>
                                      49
                                  </p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            
          </div>
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

    // for an individual element
    var flkty = new Flickity( '#adFeatureCarousel', {
        contain: true,
        pageDots: false,
        wrapAround: true,
        freeScroll: true,
        autoPlay: 1500
        });
    </script>
</body>
</html>

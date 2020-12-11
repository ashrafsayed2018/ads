<nav class="navbar navbar-expand-lg navbar-light ">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			<a href="/"><div class="logo"><?php echo $ob->sitename ; ?></div></a>
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="/" <?php echo ($index =='')? 'class="active"' :'';?>>الرئيسيه <span class="sr-only">(current)</span></a>
            </li>
          </ul>
          <ul class="navbar-nav mt-2 mt-lg-0">

            <?php
              if(isset($_SESSION['email'])){
                ?>
              <li class="nav-item"><a class="nav-link btn btn-outline-success"  href="/dashboard" <?php echo ($index =='dashboard')? 'class="active"' :'';?>>حسابي</a></li>
              <li class="nav-item"><a class="nav-link btn btn-outline-danger" href="/?logout=1">خروج</a></li>
              <?php
              } else {
              ?>
              <li class="nav-item"><a class="nav-link btn btn-outline-primary" href="/register" <?php echo ($index =='register')? 'class="active"' :'';?>>تسجيل</a></li>
              <li class="nav-item"><a class="nav-link btn btn-outline-success" href="/login" <?php echo ($index =='login')? 'class="active"' :'';?>>دخول</a></li>
              <?php

              }
              ?>
             
          </ul>
        </div>
    </nav>

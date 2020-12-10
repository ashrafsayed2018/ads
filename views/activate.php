<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php //echo $ob->sitename; ?> </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/preloader.css" />

    <link rel="stylesheet" href="/assets/style.css">
    <!-- <link rel="stylesheet" href="/assets/theme.css"> -->
 
</head>
<body>
	<div class="jumbotron">
		<h1 class="text-center">صفحة تفعيل الحساب  </h1>
        <p><?php //activate_user()


        $active  = new Activate();
        $active->activate_user();
    
        
        ?></p>
	</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/script.js"></script>
</body>
</html>
<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="fn" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous" />

  <link rel="stylesheet" href="./css/style7.css" />
  <link rel="icon" type="image/x-icon" sizes="16x16" href="./img/logo.png">
  <!-- <link rel="icon" type="image/svg+xml" sizes="16x16" href="./img/logo.png"> -->
  
  <title> کافی شاپ بالی </title>
</head>

<body >

  <!-- Header -->
  <header>
    <div class="collapse bg-dark" id="navbarHeader">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-md-7 py-1">
            <h4 class="text-white">درباره ما</h4>
            <div class="text-muted">
            <p> به سایت کافی شاپ بالی خوش اومدین </p>
			<p> آدرس : شیراز - جاده بوشهر - والفجر - کافی شاپ بالی </p>
			<p> هر روز 🍺 ساعت 🕖7:30 ➖ 21:00🕘 </p>
			<p> سفارشات شما پس از ثبت نام در سایت پذیرفته میشود. </p>
            </div>
          </div>

          <div class="col-sm-4 col-md-5 py-4">
            <h4 class="text-white">راه های ارتباطی</h4>
            <div>
              <a class="mr-2" href="https://www.google.com/maps/place/%C2%AB+%DA%A9%D8%A7%D9%81%DB%8C+%D8%B4%D8%A7%D9%BE+%D8%A8%D8%A7%D9%84%DB%8C+%C2%BB%E2%80%AD/@29.6114984,52.4536607,15z/data=!4m5!3m4!1s0x0:0x6e0018cbc6448f64!8m2!3d29.6114984!4d52.4536607" target="_blank"><i class="fas fa-map-marker-alt text-muted fa-2x"></i></a>
              <a class="mr-2" href="https://instagram.com/coffeebalishiraz?utm_medium=copy_link" target="_blank"><i class="fab fa-instagram text-muted fa-2x"></i></a>
              <a class="mr-2" href="#" target="_blank"><i class="fab fa-telegram text-muted fa-2x"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="navbar" class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
      <div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a href="signin.php" class="mx-2 mr-3"><i class="fas fa-user fa-lg ml-3""></i></a>
      </div>
      <div>
        <a href="#" class="logo"> <img src="./img/logo.png" alt="cafe-bali"> </a>
      </div>
      </div>
    </div>

  </header>
  <!-- End Header -->


      
  <div id="cafemenu" class="bg-dark">
      <a class="btn btn-outline-danger  js-scroll-trigger" href="menu.php?category=1"> نوشیدنی های گرم </a>
      <a class="btn btn-outline-primary mr-2  js-scroll-trigger" href="menu.php?category=2"> نوشیدنی های سرد </a>
      <a class="btn btn-outline-info mr-2  js-scroll-trigger" href="menu.php?category=3"> آیس </a>
      <a class="btn btn-outline-warning mr-2  js-scroll-trigger" href="menu.php?category=4"> شیک </a>
      <a class="btn btn-outline-primary mr-2  js-scroll-trigger" href="menu.php?category=5"> بستنی </a>
      <a class="btn btn-outline-danger mr-2  js-scroll-trigger" href="menu.php?category=6"> خوراکی </a>
      <a class="btn btn-outline-warning mr-2  js-scroll-trigger" href="menu.php?category=7"> محصولات </a>
    </div>
	<div class="text-center text-success">
	<?php
	if(!empty($_REQUEST['commentSend']) && $_REQUEST['commentSend'] == "true"){
		if(isset($_POST['send'])){
			if(!empty($_POST['fullName']) && !empty($_POST['email'])){
				$fullName = $_POST['fullName'];
			    $email = $_POST['email'];
			    $comment = $_POST['commentText'];
			    $commentDate = date("Y-m-d H:m:s");
				try{
       			$insert = "INSERT INTO comments
     		    (fullName, email, commentText, commentDate)
   			    VALUES (?, ?, ?, ?)";
     		    $insertStmnt = $pdoObj->prepare($insert);
      			$insertStmnt->execute([$fullName,$email,$comment,$commentDate]);
				echo "<div class=\"text-center text-success\">";
				echo "پیام به پشتیبانی با موفقیت ارسال شد";
				echo "</div>";
				}catch(PDOException $e){
					echo "<div class=\"text-center text-danger\">";
      				echo "Error: " . $e->getMessage();
					echo "</div>";
      			}
			}else{
				echo "<div class=\"text-center text-danger\">";
				echo "نام کاربری و ایمیل وارد نشده است";
				echo "</div>";
			}
		}
	}
	?>
	</div>
  <section>
    <div class="container-fluid">
      <div id="section-home" class="row justify-content-center align-items-center">
        <div class="col-sm-10 text-center">
          <h1 id="banner-heading" class="mb-5 text-warning">
            <span class="wp-text-primary">cafebali</span>.ir
          </h1>
          <h4 id="banner-par" class="font-italic mb-4 text-warning">
           به کافه بالی خوش آمدید 
          </h4>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-dark p-4">
    <div class="container-fluid text-muted">
      <div class="row">
        <div class="col-md-10">
          <p>
            تمامی حقوق مربوط به این وبسایت و محتوای آن مربوط به کافی شاپ بالی میباشد.  
			<font class="text-info">
            cafebali.ir &copy; 2021
            </font>
          </p>
        </div>

        <div class="col-md-2 text-left">
          <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#supportModal">
            ارتباط با پشتیبانی سایت
          </button>
        </div>
      </div>
    </div>
  </footer>



  <!-- Support Modal -->
  <div class="modal fade text-muted" id="supportModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> ارسال پیام به پشتیبان</h5>
          <button class="close ml-0" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form action="index.php?commentSend=true" method="post">
            <div class="form-group">
              <label for="name">نام</label>
              <input type="text" id="name" name="fullName" class="form-control">
            </div>
            <div class="form-group">
              <label for="email">ایمیل</label>
              <input type="email" id="email"  name="email" class="form-control">
            </div>
            <div class="form-group">
              <label for="message">متن پیام</label>
              <textarea type="text" id="message" name="commentText" class="form-control"></textarea>
            </div>
			<div class="modal-footer">
          <button type="submit" name="send" class="btn btn-outline-info btn-block " >ارسال</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
  crossorigin="anonymous"></script>
   
</body>

</html>
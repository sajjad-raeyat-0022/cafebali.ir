<?php include "db.php"; ?>
<?php
function redirect($url)
{
    if (!headers_sent()){
        header("Location: $url");
    }else{
        echo "<script type='text/javascript'>window.location.href='$url'</script>";
        echo "<noscript><meta http-equiv='refresh' content='0;url=$url'/></noscript>";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style7.css" />
	<link rel="icon" type="image/x-icon" sizes="16x16" href="./img/logo.png">
  <!-- <link rel="icon" type="image/svg+xml" sizes="16x16" href="./img/logo.png"> -->
    <title> ورود کاربری </title>
</head>

<body>
<header>
    <div id="navbar" class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
      <div>
        <a href="#" class="logo"> <img src="./img/logo.png" alt="cafe-bali"> </a>
      </div>
      <div>
        <a href="signup.php" class="mx-2 mr-2"><i class="fas fa-user  fa-lg ml-3""></i></a>
        <a href="index.php" class="mx-2 mr-2"><i class="fas fa-home  fa-lg ml-3""></i></a>
      </div>
      </div>
    </div>
  </header>
  <section>

    <div class="container">

    <div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
    <div class="col-lg-6">
    <div class="p-5">
    <div class="text-center">
    <h1 class="h4 text-muted mb-4"> ورود به پنل کاربری </h1>
    </div>
    <form method="POST" action="signin.php">
    <div class="form-group">
    <input type="text" maxlength="11" class="form-control border-rad" name="phoneNumber" placeholder="شماره تلفن">
    <small class="form-text text-black"> به صورت 09171234567 وارد شود </small>
    </div>
    <div class="form-group">
    <input type="password" class="form-control border-rad" name="pass" placeholder="رمز ورود">
    </div>
    <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label mr-3" for="exampleCheck1"> مرا بخاطر بسپار </label>
    </div>
    <button class="btn btn-primary btn-block border-rad" type="submit" name="submit"> ورود </button>

    <hr>
    <div class="text-center">
    <a class="small" href="#"> رمز عبور خود را فراموش کرده ام </a>
    </div>
    <div class="text-center">
    <a class="small" href="signup.php"> ساخت حساب کاربری </a>
    </div>

    <div class="text-center">
    <?php
        try{
          if(isset($_POST['submit'])){
            if(!empty($_POST['phoneNumber']) && !empty($_POST['pass'])){
              $phoneNumber = $_POST['phoneNumber'];
              $password = $_POST['pass'];
              $select = "SELECT * FROM usersInformation WHERE phoneNumber = '$phoneNumber' AND pass = '$password'";
              $selectResult= $pdoObj->query($select);
              foreach($selectResult as $row){
                if($phoneNumber == $row['phoneNumber'] && $password == $row['pass']){
                  if($row['Access'] == "client"){
                    $text1 = "menu.php"; 
                    $userID = $row['userID']; 
                    // echo $text1 ." " .$text2;
                    //header("location: menu.php?category=1&id=$userID");
					redirect("menu.php?category=1&id=$userID");
                    //exit;
                  }if($row['Access'] == "management"){
                    $text1 = "management.php";
                    $userID = $row['userID']; 
                    // echo $text1 ." " .$text2;
                    //header("Location: management.php?id=$userID");
					redirect("management.php?id=$userID");
                    //exit;
                  }
                }else{
                  echo "<b> <font color=\"red\">  !!!اطلاعات وارد شده درست نمیباشد!!!</font> </b>";
                }
              }
            }else{
              echo "<b> <font color=\"red\">  !!!لطفا اطلاعات را به درستی وارد کنید!!!</font> </b>";
            }
          }

        }catch(PDOException $e){
          echo "<b> <font color=\"red\">  !!!اطلاعات وارد شده درست نمیباشد!!!</font> </b>";
          }
        ?>
    </div>

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
  </section>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</body>

</html>
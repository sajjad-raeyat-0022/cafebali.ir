<?php include "db.php"; ?>
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
    <title> ثبت نام کاربر </title>
</head>

<body>
<header>
    <div id="navbar" class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
      <div>
        <a href="#" class="logo"> <img src="./img/logo.png" alt="cafe-bali"> </a>
      </div>
      <div>
        <a href="signin.php" class="mx-2 mr-2"><i class="fas fa-user  fa-lg ml-3""></i></a>
        <a href="index.php" class="mx-2 mr-2"><i class="fas fa-home  fa-lg ml-3""></i></a>
      </div>
      </div>
    </div>
  </header>
    <section>
        <div class="container ">
        <br>
        <div class="card shadow-lg my-5">
        <div class="card-body p-0">
        <div class="row">
        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
        <div class="col-lg-7">
        <div class="p-4">
        <div class="text-center">
        <h1 class="h4 text-muted mb-4"> ساخت حساب کاربری! </h1>
        </div>
        <form method="POST" action="signup.php">
        <div class="form-group row">
        <input type="text" class="form-control border-rad" name="fullName" placeholder=" نام و نام خانوادگی ">
        </div>
        <div class="form-group">
        <input type="text" maxlength="11" class="form-control border-rad" name="phoneNumber" placeholder=" شماره تلفن  ">
        <small class="form-text text-black"> به صورت 09171234567 وارد شود </small>
        </div>
        <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="password" class="form-control border-rad" name="pass1"  placeholder="رمز ورود">
        </div>
        <div class="col-sm-6">
        <input type="password" class="form-control border-rad" name="pass2" placeholder=" تکرار رمز ورود ">
        </div>
        </div>
        <button class="btn btn-primary border-rad btn-block" type="submit" name="submit"> ساخت اکانت </button>
        <!-- <a href="login.html" name="submit" class="btn btn-primary border-rad btn-block"> ساخت اکانت </a> -->
        <hr>
        </form>
        <div class="text-center">
        <a class="small" href="signin.php"> آیا حساب دارید؟ وارد شدن  </a>
        </div>
        <div class="text-center">
        <?php
        try{
          $select = "SELECT * FROM usersInformation";
                $selectResult= $pdoObj->query($select);
                $count = $selectResult->rowCount();

                if($count == 0){
                  $mFullName = "مدیریت";
                  $mPhoneNumber = "09170022767";
                  $mPassword = "0022767";
                  $mAge = 21;
                  $mGender = "مرد";
                  $mEmail = "raeyatsajjad@gmail.com";
                  $mFullAddress = "شیراز، شهرک ولفجر، بلوار ولفجر، ساختمان داریوش، 16";
                  $mAccess = "management";
                  $insert = "INSERT INTO usersInformation
                  (fullName, phoneNumber, pass, Access, age, gender, email, fullAddress)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                  $insertStmnt = $pdoObj->prepare($insert);
                  $insertStmnt->execute([$mFullName,$mPhoneNumber,$mPassword,$mAccess,$mAge,$mGender,$mEmail,$mFullAddress]);
                }

          if(isset($_POST['submit'])){
            if(!empty($_POST['fullName']) && !empty($_POST['phoneNumber']) && !empty($_POST['pass1']) && !empty($_POST['pass2'])){
              $password = $_POST['pass1'];
              $REpassword = $_POST['pass2'];
              if($REpassword == $password){
                $fullName = $_POST['fullName'];
                $phoneNumber = $_POST['phoneNumber'];

                $select2 = "SELECT * FROM usersInformation WHERE phoneNumber = '$phoneNumber'";
                $selectResult2= $pdoObj->query($select2);
                $count2 = $selectResult2->rowCount();
                // foreach($selectResult as $row){
                  // if($phoneNumber == $row['phoneNumber']){
                    // echo "ok";
                  if($count2 >0 ){
                    echo "<b> <font color=\"red\">  !!! شماره تلفن وارد شده قبلا ثبت نام شده است !!!</font> </b>";
                  exit;
                  // break;
                  }else{
                    $Access = "client";
                    $insert = "INSERT INTO usersInformation
                    (fullName, phoneNumber, pass, Access)
                    VALUES (?, ?, ?, ?)";
                    $insertStmnt = $pdoObj->prepare($insert);
                    $insertStmnt->execute([$fullName,$phoneNumber,$password,$Access]);
                    if($insertStmnt == true){
                      echo "<b><font color=\"green\"> اطلاعات به درستی ذخیره شده </font></b>";
                    exit;
                    // break;
                    }else{
                      echo "<b> <font color=\"red\">  !!!اطلاعات به درستی ذخیره نشده است!!!</font> </b>";
                    exit;
                    // break;
                    }
                  }
                // }
                

              }else{
                echo "<b> <font color=\"red\"> !!!پسوورد ها با هم برابر نیستند!!!</font></b>";
              }
            }else{
              echo "<b> <font color=\"red\">  !!!لطفا تمامی اطلاعات را به درستی وارد کنید!!!</font> </b>";
            }

          }

        }catch(PDOException $e){
          echo "Error: " . $e->getMessage();
          echo "<a href=\"signup.php\"> تلاش مجدد </a>";
          exit();
          }
        ?>
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
<?php include "db.php";
?>
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
  <title> منو  </title>
</head>

<body >

  <!-- Header -->
  <header>
    <div id="navbar" class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
      <div>
        <!-- <a href="#" class="navbar-brand ml-3">
          <strong>cafe-bali.ir</strong>
        </a> -->
       
        <a href="#" class="logo"> <img src="./img/logo.png" alt="cafe-bali"> </a>
      </div>
      
      <?php
          echo "<div><b><font color=\"white\">";
          if(!empty($_REQUEST['id'])){
          $userID = $_REQUEST['id'];
          $select = "SELECT fullName FROM usersInformation WHERE userID = $userID";
          $selectResult= $pdoObj->query($select);
          foreach($selectResult as $row){
            echo "خوش اومدی " .$row['fullName'];
          }
        }
        echo "</font></b>";

        if(!empty($_REQUEST['id'])){
          $userID = $_REQUEST['id'];
          echo "<a href=\"basket.php?id=$userID\" class=\"mx-2 mr-3\"><i class=\"fas fa-shopping-cart fa-lg ml-3\"></i></a>";
          echo "<a href=\"index.php\" class=\"mx-2 mr-3\"><i class=\"fas fa-sign-out-alt fa-lg ml-3\"></i></a>";
        }else{
          echo "<a href=\"signin.php\" class=\"mx-2 mr-3\"><i class=\"fas fa-user  fa-lg ml-3\"></i></a>";
          echo "<a href=\"index.php\" class=\"mx-2 mr-3\"><i class=\"fas fa-home  fa-lg ml-3\"></i></a>";
        }
        echo "</div>";
        ?>
        
      </div>
    </div>
  </header>
  <!-- End Header -->

  <section>
    <div id="cafemenu" class="bg-dark">
    <?php
    if(!empty($_REQUEST['id'])){
      $userID = $_REQUEST['id'];
      echo "<a class=\"btn btn-outline-danger  js-scroll-trigger\" href=\"menu.php?category=1&id=$userID\"> نوشیدنی های گرم </a>";
      echo "<a class=\"btn btn-outline-primary mr-2  js-scroll-trigger\" href=\"menu.php?category=2&id=$userID\"> نوشیدنی های سرد </a>";
      echo "<a class=\"btn btn-outline-info mr-2  js-scroll-trigger\" href=\"menu.php?category=3&id=$userID\"> آیس </a>";
      echo "<a class=\"btn btn-outline-warning mr-2  js-scroll-trigger\" href=\"menu.php?category=4&id=$userID\"> شیک </a>";
      echo "<a class=\"btn btn-outline-primary mr-2  js-scroll-trigger\" href=\"menu.php?category=5&id=$userID\"> بستنی </a>";
      echo "<a class=\"btn btn-outline-danger mr-2  js-scroll-trigger\" href=\"menu.php?category=6&id=$userID\"> خوراکی </a>";
      echo "<a class=\"btn btn-outline-warning mr-2  js-scroll-trigger\" href=\"menu.php?category=7&id=$userID\"> محصولات </a>";
    }else{
      echo "<a class=\"btn btn-outline-danger  js-scroll-trigger\" href=\"menu.php?category=1\"> نوشیدنی های گرم </a>";
      echo "<a class=\"btn btn-outline-primary mr-2  js-scroll-trigger\" href=\"menu.php?category=2\"> نوشیدنی های سرد </a>";
      echo "<a class=\"btn btn-outline-info mr-2  js-scroll-trigger\" href=\"menu.php?category=3\"> آیس </a>";
      echo "<a class=\"btn btn-outline-warning mr-2  js-scroll-trigger\" href=\"menu.php?category=4\"> شیک </a>";
      echo "<a class=\"btn btn-outline-primary mr-2  js-scroll-trigger\" href=\"menu.php?category=5\"> بستنی </a>";
      echo "<a class=\"btn btn-outline-danger mr-2  js-scroll-trigger\" href=\"menu.php?category=6\"> خوراکی </a>";
      echo "<a class=\"btn btn-outline-warning mr-2  js-scroll-trigger\" href=\"menu.php?category=7\"> محصولات </a>";
    }
      ?>
    </div>
  <section>
  <section>
    <div id="section-1"><br></div>
    <div class="container">

      <div class="row">

        <div class="col text-center py-2">
         <h2 class="text-center mb-2">
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
        
         $category = $_REQUEST['category'];
         switch($category){
           case 1:{$str = "نوشیدنی های گرم"; break;}          
           case 2:{$str = "نوشیدنی های سرد"; break;}   
           case 3:{$str = "آیس"; break;}   
           case 4:{$str = "شیک"; break;}   
           case 5:{$str = "بستنی"; break;}   
           case 6:{$str = "خوراکی"; break;}   
           case 7:{$str = "محصولات"; break;}   
         }
         if(!empty($_REQUEST['pay'])&&!empty($_REQUEST['id'])){
           $id = $_REQUEST['id'];
           if($_REQUEST['pay']=="true"){

            try{
              if(isset($_POST['okInfo'])){
                if(!empty($_POST['address']) || !empty($_POST['email']) || !empty($_POST['age']) || !empty($_POST['gender'])){
                  $age = $_POST['age'];
                  $gender = $_POST['gender'];
                  $email = $_POST['email'];
                  $fullAddress = $_POST['address'];
                  $update = "UPDATE usersInformation
                  SET age = '$age', gender = '$gender', email = '$email', fullAddress	= '$fullAddress'
                  WHERE userID = $id";
                  $results = $pdoObj->query($update);
                  echo "<div class=\"text-center mb-3\">";
                  echo "<b> <font color=\"green\" size=\"4\"> اطلاعات به درستی ذخیره شد </font> </b>";
                  echo "</div>";
                }else{
                  echo "<div class=\"text-center mb-3\" >";
                  echo "<b> <font color=\"red\" size=\"4\">  !!!اطلاعات تمامی فیلد ها را به درستی وارد کنید!!!</font> </b>";
                  echo "</div>";
                }
              }
            }catch(PDOException $e){
              // echo "Error: " .$e->getMessage();
              echo "<div class=\"text-center mb-3\" >";
              echo "<b> <font color=\"red\" size=\"4\">  !!!اطلاعات وارد شده درست نمیباشد!!!</font> </b>";
              echo "</div>";
            }

            $update = "UPDATE cart
            SET reception = 1
            WHERE userID2 = $id AND reception = 0";
            $results = $pdoObj->query($update);
            $update2 = "UPDATE usersInformation
            SET request = 1
            WHERE userID = $id ";
            $results2 = $pdoObj->query($update2);
             echo "<p><b><font color=\"green\" size=\"4\">";
             echo "!!!سفارشات با موفقیت ثبت شد!!!";
             echo "</font></b></p>";
           }
         }
         echo $str; 
         ?>
         </h2>
          <div class="row">
            <?php 
            $productsTbl = "products";
            $select = "SELECT *
            FROM $productsTbl
            WHERE category = $category;";
            $selectResult= $pdoObj->query($select);
            // echo "<br>Select Query: DONE";
            foreach($selectResult as $row):
            ?>
            <div class="col-lg-3 mb-4">
              <div class="card">
              <?php echo "<img class=\"card-img-top\" src=\"" .$row['imageName'] ."\"alt=\"image\">"; ?>
                <!-- <img class="card-img-top" src="./img/cafe1.jpg" alt="" /> -->
                <div class="card-body">
                  <h5 class="card-title text-muted"> <?php echo $row['fullName'] ?> </h5>
                  <p class="card-text text-muted">
                  <?php echo $row['descriptions'] ?> 
                  </p>
                  <p class="card-text text-muted">
                  <?php echo $row['price'] ." تومان " ?> 
                  </p>
                  
                  <?php 
                  echo "<div>";
                  $productsID = $row['productsID'];
                  if(!empty($userID)){
                    echo "<a href=\"basket.php?productsID=$productsID&id=$userID\" class=\"btn btn-success\"> افزودن به سبد خرید </a>";

                    // echo "<select  name=\"number\" id=\"\" class=\"\">";
                    // for($number=1 ; $number<9 ; $number++){
                    //   echo "<option value=\"" .$number ."\"";
                    //   if($number==1){
                    //    echo "selected>" .$number ."</option>";
                    //   }else{
                    //     echo ">" .$number ."</option>";
                    //   }
                    //   }
                    //   echo "</select>";

                  }
                  echo "</div>";
                  ?>
                  
                </div>
              </div>
            </div>
            <?php endforeach; ?>
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
        <?php
        if(!empty($_REQUEST['id'])){
          $userID = $_REQUEST['id'];
          echo "<form action=\"menu.php?id=$userID&category=1&commentSend=true\" method=\"post\">";
        }else{
          echo "<form action=\"menu.php?category=1&commentSend=true\" method=\"post\">";
        }
          ?>
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
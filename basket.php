<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style7.css" />
	<link rel="icon" type="image/x-icon" sizes="16x16" href="./img/logo.png">
  <!-- <link rel="icon" type="image/svg+xml" sizes="16x16" href="./img/logo.png"> -->
    <title> سبد خرید </title>
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
        
        echo "</font></b>";
        echo "<a href=\"menu.php?category=1&id=$userID\" class=\"mx-2 mr-3\"><i class=\"fas fa-sign-out-alt fa-lg ml-3\"></i></a>";
        }else{
        echo "<a href=\"menu.php?category=1\" class=\"mx-2 mr-3\"><i class=\"fas fa-sign-out-alt fa-lg ml-3\"></i></a>";
        }
        echo "</div>";
        ?>
        
      </div>
    </div>
  </header>
  <!-- End Header -->

  <section class="section">
  <div class="container-fluid">

      <div class="row">
      <div class="col-xl-10 col-lg-9 col-md-9 m-auto">


  <h4 class="text-center text-center font-weight-bold mb-3 mt-4"> سبد خرید شما </h4>

<table class="table bg-light text-center">

  <thead class="thead-light">
    <tr>
      <th>#</th>
      <th> تصویر </th>
      <th> نام محصول </th>
      <th> دسته بندی </th>
      <th> توضیحات </th>
      <th> قیمت </th>
      <th> زمان </th>
      <th> حذف </th>
    </tr>
  </thead>

  <?php
  
  if(!empty($_REQUEST['productsID'])){
    $productsID = $_REQUEST['productsID'];
    $select = "SELECT * FROM products WHERE productsID = $productsID";
    $selectResult= $pdoObj->query($select); 
    foreach($selectResult as $row){
        $fullName = $row['fullName'];
        $price = $row['price'];
        $descriptions = $row['descriptions'];
        $imageName = $row['imageName'];
        $category = $row['category'];
        switch($category){
            case 1:{$str = "نوشیدنی های گرم"; break;}          
            case 2:{$str = "نوشیدنی های سرد"; break;}   
            case 3:{$str = "آیس"; break;}   
            case 4:{$str = "شیک"; break;}   
            case 5:{$str = "بستنی"; break;}   
            case 6:{$str = "خوراکی"; break;}   
            case 7:{$str = "محصولات"; break;}   
          }
    }
    try{
        $today = date("Y-m-d H:m:s");
        $insert = "INSERT INTO cart
        (fullName, price, descriptions, imageName, category, userID2, productsID2, cartDate)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmnt = $pdoObj->prepare($insert);
        $insertStmnt->execute([$fullName,$price,$descriptions,$imageName,$str,$userID,$productsID,$today]);
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        exit();
        }

    }
    if(!empty($_REQUEST['id'])){
    $userID = $_REQUEST['id'];
    $select = "SELECT * FROM cart 
    WHERE userID2 = $userID AND reception = 0";
    $selectResult= $pdoObj->query($select); 
    $count = $selectResult->rowCount();

  echo "<tbody>";
   foreach($selectResult as $row){
    $id = $row['cartID'];
    echo "<tr>"
      ."<td>" .$id ."</td>"
      ."<td>"
      ."<img style=\" width:75px; height: 75px;\" src=\"" .$row['imageName'] ."\" alt=\"product\">"
      ."</td>"
      ."<td>" .$row['fullName'] ."</td>"
      ."<td>" .$row['category'] ."</td>"
      ."<td>" .$row['descriptions'] ."</td>"
      ."<td>" .$row['price'] ."</td>"
      ."<td>" .$row['cartDate'] ."</td>"
      ."<td>"
      ."<a href=\"basket.php?pID=$id&id=$userID\" class=\"btn btn-outline-danger\"> حذف </a>"
      ."</td>"
      ."</tr>";
	  $sum += $row['price'];

   }
   echo "</tbody>";
   if(!empty($_REQUEST['pID'])){
    $remove = $_REQUEST['pID'];
      // $id = $row['cartID'];
      $delete = "DELETE FROM cart
      WHERE cartID = $remove";
      $results = $pdoObj->query($delete);
  }
  
   }

echo "</table>";
if($count == 0){
  echo "<div class=\"text-center mb-3 mt-3\">";
  echo "<p><b><font color=\"red\" size=\"4\">";
  echo "!!!سبد خرید شما خالی میباشد!!!";
  echo "</font></b></p>";
  echo "</div>";
}else{
  echo "<div class=\"text-center\">";
  echo "<p><b> قیمت کل : " .$sum ." تومان </b></p>";
  echo "</div>";
  $select = "SELECT * FROM usersInformation 
  WHERE userID = $userID";
  $selectResult= $pdoObj->query($select); 
  foreach($selectResult as $row){
    if($row['age'] == NULL || $row['gender'] == NULL || $row['email'] == NULL || $row['fullAddress'] == NULL){
      echo "<div class=\"text-center mb-3\">";
      echo "<a href=\"#\" onclick=\"openFormInformation()\" class=\"btn btn-info\"> تکمیل اطلاعات </a>";
      echo "</div>";
    }else{
      echo "<div class=\"text-center mb-3\">";
      echo "<a href=\"menu.php?id=$userID&category=1&pay=true\" class=\"btn btn-success\"> پرداخت و ثبت سفارش </a>";
      echo "</div>";
	  
    }
  }
}

?>
    </div>
   </div>
   </div>
  </section>


  <div class="modal" id="information" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"> تکمیل اطلاعات </h5>
      </div>
      <div class="modal-body">
      <?php echo "<form action=\"menu.php?id=$userID&category=1&pay=true\" method=\"post\">"; ?>
          <div class="form-group">
              <input type="text" class="form-control border-rad"  placeholder=" آدرس " name="address">
          </div>
          <div class="form-group">
            <input type="email" class="form-control border-rad"  placeholder=" ایمیل " name="email">
          </div>
          <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input type="number" class="form-control border-rad" placeholder=" سن " name="age">
            </div>
            <div class="col-sm-6">
              <input type="text" class="form-control border-rad" placeholder=" جنسیت " name="gender">
            </div>
          </div>
            <div class = "modal-footer">
            <input type="submit" name="okInfo" value="پرداخت و ثبت اطلاعات" class="btn btn-success border-rad btn-block">
         </div>
		       <button type="button" class="cancel btn btn-danger border-rad btn-block" onclick="closeFormInformation()"> خروج </button>
         </form>
      </div>
    </div>
  </div>
</div>
</div>



  <script>
function openFormInformation() {
  document.getElementById("information").style.display = "block";
}

function closeFormInformation() {
  document.getElementById("information").style.display = "none";
}
  </script>


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
<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous" />

  <link rel="stylesheet" href="./css/style_dashboard5.css" />
  <link rel="icon" type="image/x-icon" sizes="16x16" href="./img/logo.png">
  <!-- <link rel="icon" type="image/svg+xml" sizes="16x16" href="./img/logo.png"> -->
  <title> پنل مدیریت </title>
</head>

<body>

  <nav class="navbar navbar-expand-md navbar-light">

    <button class="navbar-toggler mr-auto mb-2 bg-light" type="button" data-toggle="collapse" data-target="#myNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="myNavbar">

      <div class="container-fluid">

        <div class="row">

          <div class="col-md-3 col-lg-3 col-xl-2 sidebar shadow-lg fixed-top">

          <br>
            <div class="border-bottom pb-3">
              <a href="#"
              ><span class="text-primary logo"
                ><img
                  src="./img/logo.png"
                  alt="cafebali Logo"
                  width="170px"
                  height="100px" /></span
            ></a>
              <br>
              <p><b> <font color="red">
              <?php
               $userID = $_REQUEST['id'];
               $select = "SELECT fullName FROM usersInformation WHERE userID = $userID";
               $selectResult= $pdoObj->query($select);
               foreach($selectResult as $row){
                 echo $row['fullName'];
               }
              ?>
              </font></b></p>
            </div>

            <ul class="navbar-nav flex-column mt-4 p-0">
              <?php
              echo "<li class=\"nav-item\"><a class=\"nav-link text-right text-white sidebar-link p-2 mb-2 current action\" href=\"management.php?id=$userID\">
                  <i class=\"fas fa-home text-light fa-lg ml-3\"></i> داشبورد </a></li>";
              echo "<li class=\"nav-item\"><a class=\"nav-link text-right text-white sidebar-link p-2 mb-2\" href=\"comments.php?id=$userID\"><i
                    class=\"fas fa-envelope text-light fa-lg ml-3\"></i> پیام ها </a></li>";
              echo "<li class=\"nav-item\"><a class=\"nav-link text-right text-white sidebar-link p-2 mb-2\" href=\"products.php?id=$userID\"><i
                    class=\"fas fa-inbox text-light fa-lg ml-3\"></i> محصولات </a></li>";
              ?>
              <li class="nav-item"><a class="nav-link text-right text-white sidebar-link p-2 mb-2" href="index.php"><i class="fas fa-sign-out-alt text-light fa-lg ml-3"></i> خروج </a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <section class="section">

    <div class="container-fluid">

      <div class="row">

        <div class="col-xl-10 col-lg-9 col-md-9 mr-auto">



      
      <div class="col-6">
        <h3>
          <i class="fas fa-cog" ></i> داشبورد </h3>
      </div>
      <?php
	  if(empty($_REQUEST['userCartID']) && !empty($_REQUEST['id'])):
      $select = "SELECT * FROM usersInformation";
      $selectResult= $pdoObj->query($select);
      // $count = $selectResult->rowCount();
      ?>
            
              <h4 class="text-center text-center font-weight-bold mb-3"> کاربران </h4>

              <table class="table bg-light text-center">

                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th> نام </th>
                    <th> سن </th>
                    <th> جنسیت </th>
                    <th> ایمیل </th>
                    <th> آدرس </th>
                    <th> شماره تلفن </th>
                    <th> ارسال پیام </th>
                  </tr>
                </thead>

                <tbody>
                <?php foreach($selectResult as $row) : ?>
                  <tr>
                    <td><?php echo $row['userID'] ?></td>
                    <td><?php echo $row['fullName'] ?></td>
                    <td><?php echo $row['age'] ?></td>
                    <td><?php echo $row['gender'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['fullAddress'] ?></td>
                    <td><?php echo $row['phoneNumber'] ?></td>
                    <td>
                      <a href="#" class="btn btn-outline-danger"> ارسال پیام </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>

              </table>

              <br>
              <h4 class="text-center text-center font-weight-bold mb-3"> جدول درخواست ها </h4>

              <table class="table bg-light text-center">
            
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th> نام کاربر </th>
                    <th> آدرس </th>
                    <th> شماره تلفن </th>
                    <th> تاریخ </th>
                    <th> مشاهده سفارشات </th>
                  </tr>
                </thead>
                <?php
                 $select = "SELECT * FROM usersInformation WHERE request = 1";
                 $selectResult= $pdoObj->query($select);
               
                echo "<tbody>";
                $i=0;
                foreach($selectResult as $row){
                  $i++;
                  echo "<tr>";
                  echo "<td>" .$i ."</td>";
                  echo "<td>" .$row['fullName'] ."</td>";
                  echo "<td>" .$row['fullAddress'] ."</td>";
                  echo "<td>" .$row['phoneNumber'] ."</td>";
                  $userID2 = $row['userID'];
                  $select2 = "SELECT * FROM cart WHERE userID2 = $userID2";
                  $selectResult2 = $pdoObj->query($select2);
                  foreach($selectResult2 as $row2){
                    echo "<td>" .$row2['cartDate'] ."</td>";
					$userCartID = $row2['userID2'];
                  break;
                  }
                    echo "<td><a href=\"management.php?id=$userID&userCartID=$userCartID\" class=\"btn btn-outline-info\"> مشاهده </a></td>";
                    echo "</tr>";
                  
                }
                echo "</tbody>";
                  ?>
                
            
              </table>

			  <?php 
			  endif;
			  if(!empty($_REQUEST['userCartID']) && !empty($_REQUEST['id'])){
				  $userCartID = $_REQUEST['userCartID'];
				  echo "<div class=\"col-md-12 mt-2 text-center\">";

                    echo "<h4> سفارشات کاربر </h4>";
                    echo "<table class=\"table table-striped mt-4\">";
                    echo "<thead class=\"bg-dark text-white\">";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th> نام محصول </th>";
                    echo "<th> دسته بندی </th>";
                    echo "<th> قیمت </th>";
					echo "<th> توضیحات </th>";
                    echo "<th> تاریخ ثبت سفارش </th>";
                    echo "<th> عکس </th>";
                    echo "</tr>";
                        echo "</thead>";
                        $select = "SELECT * FROM cart WHERE reception = 1 AND userID2 = $userCartID";
                        $selectResult= $pdoObj->query($select);
                      
                       echo "<tbody>";
                       $i=0;
                       $sum=0;
                       foreach($selectResult as $row){
                         $i++;
                         echo "<tr>";
                         echo "<td>" .$i ."</td>";
                         echo "<td>" .$row['fullName'] ."</td>";
                         echo "<td>" .$row['category'] ."</td>";
                         echo "<td>" .$row['price'] ."</td>";
						 echo "<td>" .$row['descriptions'] ."</td>";
                         echo "<td>" .$row['cartDate'] ."</td>";
                         echo "<td>" ."<img style=\" width:75px; height: 75px;\" src=\"" .$row['imageName'] ."\"alt=\"image\">" ."</td>";
                           echo "</tr>";
						          $sum += $row['price'];
                       }
                       echo "</tbody>";
                       echo "</table>";
					   echo "<div class=\"text-center\">";
					   echo "<p><b> پرداخت شده : " .$sum ." تومان </b></p>";
					   echo "</div>";
                       echo "<a href=\"management.php?id=$userID&userCartID2=$userCartID&cartRequest=true\" class=\"btn btn-success mt-2\"> تایید سفارشات </a>";
                       echo "</div>";
			  }
			  if(!empty($_REQUEST['cartRequest']) && $_REQUEST['cartRequest'] == "true"){
                    $userCartID = $_REQUEST['userCartID2'];

                    $update1 = "UPDATE cart SET reception = 2 WHERE userID2 = $userCartID AND reception = 1";
                    $results = $pdoObj->query($update1);

                    $update2 = "UPDATE usersInformation SET request = 0 WHERE userID = $userCartID";
                    $pdoObj->query($update2);
					echo "<div class=\"text-center\">";
                    echo "<p><b class=\"text-center text-success\"> سفارشات کاربر ارسال شد </b></p>";
					echo "</div>";
                }
			  ?>
        </div>

      </div>

    </div>

  </section>
  


  <script src="http://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
    integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
  

</body>

</html>
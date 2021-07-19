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

  <link rel="stylesheet" href="./css/style_dashboard5.css" />
  <link rel="icon" type="image/x-icon" sizes="16x16" href="./img/logo.png">
  <!-- <link rel="icon" type="image/svg+xml" sizes="16x16" href="./img/logo.png"> -->
  <title> پیام ها </title>
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
          <a href="management.php"
          ><span class="text-primary logo"
            ><img
              src="./img/logo.png"
              alt="cafebali Logo"
              width="170px"
              height="100px" /></span
        ></a>
          <br>
          <b> <font color="red">
      <?php
          if(!empty($_REQUEST['id'])){
          $userID = $_REQUEST['id'];
          $select = "SELECT fullName FROM usersInformation WHERE userID = $userID";
          $selectResult= $pdoObj->query($select);
          foreach($selectResult as $row){
            echo $row['fullName'];
          }
        }
        ?>
        </font></b>
        </div>

        <ul class="navbar-nav flex-column mt-4 p-0">
              <?php
              echo "<li class=\"nav-item\"><a class=\"nav-link text-right text-white sidebar-link p-2 mb-2 \" href=\"management.php?id=$userID\">
                  <i class=\"fas fa-home text-light fa-lg ml-3\"></i> داشبورد </a></li>";
              echo "<li class=\"nav-item\"><a class=\"nav-link text-right text-white sidebar-link p-2 mb-2 current action\" href=\"comments.php?id=$userID\"><i
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

<div class="container-fluid col-xl-6 mt-3 mb-5">
    <h3> پیام ها </h3>
</div>
<section class="section">
<div class="container-fluid">

<?php
$select = "SELECT * FROM comments";
$selectResult= $pdoObj->query($select);
foreach($selectResult as $row){
	$commentID = $row['commentID'];
  echo "<div class=\"row mt-3 mb-2\">";
    echo "<i class=\"far fa-comment text-warning fa-4x mr-auto mt-1 text-right\"></i>";
    echo "<div class=\"col-xl-9 col-lg-9 col-md-9 \">";
         echo "<div class=\"comment-context media-body bg-light p-2\">";
                echo "<p>" .$row['commentDate'] ."</p>";
                echo "<h5 class=\"text-right\"><u>" .$row['fullName'] ."</u></h5>";
                echo "<p> آدرس ایمیل :" .$row['email'] ."</p>";
                echo "<hr>";
                echo "<div class=\"mt-2\">";
                    echo "<b> متن پیام : </b>";
                    echo "<p class=\"mt-1\">" .$row['commentText'] ."</p>";
                echo "</div>";
        echo "</div>";
        echo "<a class=\"btn btn-outline-info mt-2\" href=\"comments.php?id=$userID&commentID=$commentID\"> ارسال ایمیل </a>";
    echo "</div>";
  echo "</div>";
}
?>
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
   
</body>

</html>
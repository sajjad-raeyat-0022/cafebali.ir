<?php 
include "db.php";
$pdoObj->beginTransaction();
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

  <link rel="stylesheet" href="./css/style_dashboard5.css" />
  <link rel="icon" type="image/x-icon" sizes="16x16" href="./img/logo.png">
  <!-- <link rel="icon" type="image/svg+xml" sizes="16x16" href="./img/logo.png"> -->
  <title> اطلاعات محصولات </title>
</head>

<body>
<?php
echo "<div style=\"color:red;\" class=\"text-center\">";
$msg = "";
if (isset($_POST['insertProduct'])) {
  if(isset($_FILES['uploadimage']) && $_FILES['uploadimage']['size']>0){

    $validMimeTypes = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png', 'image/PNG');
    $validFileExt = array('.gif','.jpeg','.jpg','.JPG', '.png','.PNG');
    $file_info = new finfo(FILEINFO_MIME_TYPE);
    $binaryFileStr = file_get_contents($_FILES['uploadimage']['tmp_name']);
    $mime_type = $file_info->buffer($binaryFileStr);
    $fileExtIndex = array_search(strtolower($mime_type),$validMimeTypes);
    if($fileExtIndex != false){
    $ext = $validFileExt[$fileExtIndex];
    }else{
    echo "<br> فرمت تصویر وارد شده درست نیست <br>";
    echo "<a href=\"products.php\"> تلاش مجدد </a>";
    exit();
    }

echo "ok";
$fullName = $_POST['name'];
$price = $_POST['price'];
$descriptions = $_POST['descriptions'];
$category = $_POST['category'];


$ImageDir = "img/";
$imageName = explode('.',$_FILES['uploadimage']['name']);
$tmpImageUrl = $ImageDir.$imageName[0].$ext;
$moveOperation = move_uploaded_file($_FILES['uploadimage']['tmp_name'], $tmpImageUrl);

if($moveOperation == true){  
  try{
      $insert = "INSERT INTO products
      (fullName, price, descriptions, imageName, category)
      VALUES (?, ?, ?, ?, ?)";
      $insertStmnt = $pdoObj->prepare($insert);
      $insertStmnt->execute([$fullName,$price,$descriptions,$tmpImageUrl,$category]);

      $picId = $pdoObj->lastInsertId();
      $randomName = bin2hex(random_bytes(10));
      $uniqueFileName = $randomName.$picId.$ext;
      $imageUrl = "img/" . $uniqueFileName;
      $renameOp = rename($tmpImageUrl, $imageUrl);
  
      if($renameOp == true){
          $update = "UPDATE products SET imageName = '$imageUrl' WHERE productsID = $picId";
          $pdoObj->query($update);    
          $pdoObj->commit();  
          } else{
          echo "<br> تغییر نام فایل به درستی انجام نشده است<br>";
          echo "<a href=\"products.php\"> تلاش مجدد </a>";
          exit();
          }

      } catch(PDOException $e){
      echo "Error: " . $e->getMessage();
      echo "<a href=\"products.php\"> تلاش مجدد </a>";
      $pdoObj->rollback();
      exit();
      }
  
  
  }else{
  echo "<br>File Submission Error1!<br>";
  echo "<a href=\"products.php\"> تلاش مجدد </a>";
  $pdoObj->rollback();
  exit();
  }

}else{
  echo "<br>Submission Error2!<br>";
  echo "<a href=\"products.php\"> تلاش مجدد </a>";
  $pdoObj->rollback();
  exit();
  }
}

if (isset($_POST['updateProduct'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $descriptions = $_POST['descriptions'];
  $imageName = $_FILES["uploadimage"]["name"];
  $tempname = $_FILES["uploadimage"]["tmp_name"];    
  $folder = "img/".$imageName;

  $select = "SELECT * FROM products";
  $result = $pdoObj->query($select);
  foreach($result as $temp){
    if($imageName != $temp['imageName'] && !empty($imageName)){      
  $update = "UPDATE products
  SET fullName = '$name', price = '$price', descriptions = '$descriptions', imageName	= '$imageName', category = '$category'
  WHERE productsID = $id";
  $results = $pdoObj->query($update);
  break;
    }else {
      echo "<br>" ."عکس انتخاب شده تکراری میباشد";
      
      break;
    }
  }
  
   if (move_uploaded_file($tempname, $folder))  {
    $msg = "Image uploaded successfully";
}else{
    $msg = "Failed to upload image";
}
}

if(isset($_POST['deleteProduct'])){
      if(!empty($_POST['id'])){
    $id = $_POST['id'];
    $delete = "DELETE FROM products
    WHERE productsID = $id;";
    $results = $pdoObj->query($delete);
    if($results == TRUE){
    echo "<b> به درستی حذف شد </b>";
    }else{
    echo "<div class=\"text-danger text-center\">";
    echo "<b> به درستی حذف نشده </b>";
    echo "</div>";
    } 
    }else{
        echo "<div class=\"text-danger text-center\">";
        echo "<b> لطفا آی دی محصول را به درستی وارد کنید </b>";
        echo "</div>";
    }
  }

  echo "</div>";
?>
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
              echo "<li class=\"nav-item\"><a class=\"nav-link text-right text-white sidebar-link p-2 mb-2\" href=\"comments.php?id=$userID\"><i
                    class=\"fas fa-envelope text-light fa-lg ml-3\"></i> پیام ها </a></li>";
              echo "<li class=\"nav-item\"><a class=\"nav-link text-right text-white sidebar-link p-2 mb-2 current action\" href=\"products.php?id=$userID\"><i
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
        <section id="actions" class="mb-4">
          <div class="container">
               <div class="row">
                   <div class="col-md-4 mb-3">
                      <div class="card shadow py-3">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <h5 class="font-weight-bold text-primary mb-3"><i class="fas fa-clipboard-list text-muted"> </i> افزودن
                              </h5>
                              <h2 class="count mb-0 font-weight-bold text-muted"> 
                              <?php 
                              $select = "SELECT * FROM products";
                              $result = $pdoObj->query($select);
                              $count = $result->rowCount();
                              echo $count;                                 
                              ?> 
                              </h2>
                            </div>
                            <div class="col-auto">
                              <a href="#" data-toggle="modal" data-target="#addPostModal">
                                <i class="fas fa-plus-circle fa-3x text-primary"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
              
              <div class="card shadow py-3">
      
                <div class="card-body">
      
                  <div class="row no-gutters align-items-center">
      
                    <div class="col mr-2">
                      <h5 class="font-weight-bold text-warning mb-3"><i class="fas fa-clipboard-list text-muted"></i> ویرایش </h5>
                      <!-- <h2 class="count mb-0 font-weight-bold text-muted"> 76 </h2> -->
                    </div>
      
                    <div class="col-auto">
                      <a href="#" data-toggle="modal" data-target="#updatePostModal">
                        <i class="fas fa-plus-circle fa-3x text-warning"></i>
                      </a>
                    </div>
      
                  </div>
      
                </div>
      
              </div>
      
            </div>
            <div class="col-md-4 mb-3">
              
              <div class="card shadow py-3">
      
                <div class="card-body">
      
                  <div class="row no-gutters align-items-center">
      
                    <div class="col mr-2">
                      <h5 class="font-weight-bold text-danger mb-3"><i class="fas fa-clipboard-list text-muted"></i> حذف </h5>
                      <!-- <h2 class="count mb-0 font-weight-bold text-muted"> 76 </h2> -->
                    </div>
      
                    <div class="col-auto">
                      <a href="#" data-toggle="modal" data-target="#deletePostModal">
                        <i class="fas fa-plus-circle fa-3x text-danger"></i>
                      </a>
                    </div>
      
                  </div>
      
                </div>
      
              </div>
      
            </div>
            
            </section>


        <?php for($i=1 ; $i<8 ; $i++):
          
          $productsTbl = "products";
          $select = "SELECT *
          FROM $productsTbl
          WHERE category = $i;";
          $selectResult= $pdoObj->query($select);
          ?>
  <h4 class="text-center font-weight-bold mb-3"> 
                    <?php 
                               switch($i){
                                 case 1: echo "نوشیدنی های گرم"; break;
                                 case 2: echo "نوشیدنی های سرد"; break;
                                 case 3: echo "آیس"; break;
                                 case 4: echo "شیک"; break;
                                 case 5: echo "بستنی"; break;
                                 case 6: echo "خوراکی"; break;
                                 case 7: echo "محصولات"; break;
                               }
                         ?>  </h4>

              <table class="table bg-light text-center">
                <thead class="thead-dark">
                  <tr>
                    <th> آی دی محصول</th>
                    <th> نام محصول </th>
                    <th> قیمت </th>
                    <th> توصیحات </th>
                    <th> نام عکس </th>
                    <th> عکس </th>
                    <!-- <th> ویرایش/حذف </th> -->
                  </tr>
                </thead>

                <tbody>
                <?php foreach($selectResult as $row): ?>
                  <tr>
                    <td> <?php echo $row['productsID'] ?> </td>
                    <td> <?php echo $row['fullName'] ?> </td>
                    <td> <?php echo $row['price'] ?> </td>
                    <td> <?php echo $row['descriptions'] ?> </td>
                    <td> <?php echo $row['imageName'] ?> </td>
                    <td > <?php echo "<img style=\" width:75px; height: 75px;\" src=\"" .$row['imageName'] ."\"alt=\"image\">"; ?> </td>
                  </tr>
                 <?php endforeach; ?>
                </tbody>

              </table>
              <?php endfor; ?>
            
    <!-- UPDATE POST MODAL -->
    <div class="modal fade" id="updatePostModal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                      <h5 class="modal-title"> ویرایش </h5>
                      <button class="close ml-0" data-dismiss="modal">
                        <span>&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="products.php" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="title"> آی دی </label>
                          <input type="text" class="form-control" name="id">
                        </div>
                        <div class="form-group">
                          <label for="title"> نام </label>
                          <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                          <label for="category"> دسته بندی </label>
                          <select class="form-control" name="category">
                            <option value="1"> نوشیدنی های گرم </option>
                            <option value="2"> نوشیدنی های سرد </option>
                            <option value="3"> آیس </option>
                            <option value="4"> شیک </option>
                            <option value="5"> بستنی </option>
                            <option value="6"> خوراکی </option>
                            <option value="7"> محصولات </option>
                          </select>
                          <br>
                          <div class="form-group">
                          <label for="title"> قیمت </label>
                          <input type="text" class="form-control" name="price">
                        </div>
                        </div>
                         <div class="form-group">
                          <label for="body"> توضیحات </label>
                          <textarea name="descriptions" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="image"> آپلود تصویر </label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="uploadimage">
                            <label for="image" class="custom-file-label text-left"> انتخاب فایل </label>
                          </div>
                          <small class="form-text text-muted"> حداکثر سایز 3 مگابایت </small>
                        </div>
                        <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-warning"  name="updateProduct"> ثبت </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ADD POST MODAL -->
              <div class="modal fade" id="addPostModal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title"> افرودن </h5>
                      <button class="close ml-0" data-dismiss="modal">
                        <span>&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="products.php" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="title"> نام </label>
                          <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                          <label for="category"> دسته بندی </label>
                          <select class="form-control" name="category">
                            <option value="1"> نوشیدنی های گرم </option>
                            <option value="2"> نوشیدنی های سرد </option>
                            <option value="3"> آیس </option>
                            <option value="4"> شیک </option>
                            <option value="5"> بستنی </option>
                            <option value="6"> خوراکی </option>
                            <option value="7"> محصولات </option>
                          </select>
                          <br>
                          <div class="form-group">
                          <label for="title"> قیمت </label>
                          <input type="text" class="form-control" name="price">
                        </div>
                        </div>
                         <div class="form-group">
                          <label for="body"> توضیحات </label>
                          <textarea name="descriptions" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="image"> آپلود تصویر </label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="uploadimage">
                            <label for="image" class="custom-file-label text-left"> انتخاب فایل </label>
                          </div>
                          <small class="form-text text-muted"> حداکثر سایز 3 مگابایت </small>
                        </div>
                        <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-primary"  name="insertProduct"> ثبت </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ADD CATEGORY MODAL -->
              <div class="modal fade" id="addCategoryModal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                      <h5 class="modal-title"> ثبت دسته بندی جدید</h5>
                      <button class="close ml-0" data-dismiss="modal">
                        <span>&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="form-group">
                          <label for="title"> عنوان </label>
                          <input type="text" class="form-control">
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer justify-content-start">
                      <button class="btn btn-success" data-dismiss="modal"> ثبت دسته </button>
                    </div>
                  </div>
                </div>
              </div>
    <!-- DELETE POST MODAL -->
             <div class="modal fade" id="deletePostModal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                      <h5 class="modal-title"> حذف </h5>
                      <button class="close ml-0" data-dismiss="modal">
                        <span>&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="products.php">
                    <div class="form-group">
                    <label for="title"> آی دی </label>
                    <input type="text" class="form-control" name="id">
                    </div>
                    <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-danger"  name="deleteProduct"> حذف </button>
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
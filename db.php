<?php
try{ 
$host = "localhost";
$username = "root";
$password = "";
$charset = "utf8";
$dbname = "cafebali_db";

$dsn = "mysql:host=$host;charset=$charset";
$pdoObj = new PDO($dsn, $username, $password);
$pdoObj->setAttribute(PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION);
$dbQuery= "CREATE DATABASE IF NOT EXISTS `$dbname`
           DEFAULT CHARACTER SET utf8
           COLLATE utf8_persian_ci;";

$pdoObj->query($dbQuery);
$pdoObj->query("use `$dbname`;");

$usersInformationTbl= "CREATE TABLE IF NOT EXISTS usersInformation(
    userID int(11) NOT NULL auto_increment,
    pass varchar(200) NOT NULL,
    fullName varchar(100) NOT NULL,
    age int(10),
    gender varchar(10),
    email varchar(200) UNIQUE,
    fullAddress TEXT,
    phoneNumber varchar(12) NOT NULL ,
    Access varchar(10) NOT NULL DEFAULT 'client',
    request varchar(10) NOT NULL DEFAULT 0,
    PRIMARY KEY (userID)
    )";
    $results = $pdoObj->query($usersInformationTbl);

$productsTbl= "CREATE TABLE IF NOT EXISTS products(
     productsID int(11) NOT NULL auto_increment,
     fullName varchar(100) NOT NULL,
     price int(200),
     descriptions TEXT,
     imageName varchar(100) NOT NULL,
     category varchar(20) NOT NULL,
     PRIMARY KEY (productsID)
     )";
     $results = $pdoObj->query($productsTbl);

$cartTbl= "CREATE TABLE IF NOT EXISTS cart(
     cartID int(11) NOT NULL auto_increment,
     fullName varchar(100) NOT NULL,
     price int(200),
     descriptions TEXT,
     imageName varchar(100) NOT NULL,
     category varchar(20) NOT NULL,
     reception int(2) NOT NULL DEFAULT 0 ,
     userID2 int(11) NOT NULL,
     productsID2 int(11) NOT NULL,
     cartDate DATETIME NOT NULL,
     PRIMARY KEY (cartID),
     FOREIGN KEY (userID2) REFERENCES usersInformation (userID) ON DELETE RESTRICT ON UPDATE CASCADE,
     FOREIGN KEY (productsID2) REFERENCES products (productsID) ON DELETE RESTRICT ON UPDATE CASCADE
     )";
     $results = $pdoObj->query($cartTbl);

$commentsTbl= "CREATE TABLE IF NOT EXISTS comments(
     commentID int(11) NOT NULL auto_increment,
     fullName varchar(100) NOT NULL,
	 email varchar(100) NOT NULL,
     commentText TEXT,
     commentDate DATETIME NOT NULL,
     PRIMARY KEY (commentID)
     )";
     $results = $pdoObj->query($commentsTbl);
 

}catch(PDOExeption $e){
    echo "Error: " .$e->getMessage();
}

?>
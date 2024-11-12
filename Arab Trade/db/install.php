<?php require_once("config.php");?>

<?php

//php datebase Object (PDO) :
$Connection = new PDO($dsn, $dbUser, $dbUserPass, $option);

$sql1 = "CREATE TABLE if not EXISTS users (
  id INT PRIMARY KEY AUTO_INCREMENT ,
  status tinyint,
  first_name varchar(255),
  last_name varchar(255),
  email varchar(255),
  Password varchar(255),
  image varchar(255),
  type varchar(255)
  )";
$Connection->exec($sql1);

$sql2 = "CREATE TABLE if not EXISTS degree (
  id INT PRIMARY KEY AUTO_INCREMENT ,
  image varchar(255),
  inserted_by INT,
  updated_date DATE,
  FOREIGN KEY (inserted_by) REFERENCES users (id)
)";
$Connection->exec($sql2);

$sql3 = "CREATE TABLE if not EXISTS courses (
  id INT PRIMARY KEY AUTO_INCREMENT ,
  title varchar(3000),
  content varchar(3000),
  inserted_by INT,
  inserted_date date,
  updated_by INT,
  updated_date DATE,
  image varchar(255),
  status tinyint,
  FOREIGN KEY (inserted_by) REFERENCES users (id)
)";
$Connection->exec($sql3);

$sql4 = "CREATE TABLE if not EXISTS post (
  id INT PRIMARY KEY AUTO_INCREMENT ,
  title varchar(3000),
  content varchar(3000),
  inserted_by INT,
  inserted_date date,
  updated_by INT,
  updated_date DATE,
  status tinyint,
  image varchar(255),
  FOREIGN KEY (inserted_by) REFERENCES users (id)
)";
$Connection->exec($sql4);

$sql5 = "CREATE TABLE if not EXISTS comment (
  id INT PRIMARY KEY AUTO_INCREMENT ,
  content varchar(255),
  inserted_by INT,
  inserted_date date,
  updated_by INT,
  updated_date DATE,
  status tinyint,
  post_id INT,
  FOREIGN KEY (inserted_by) REFERENCES users (id),
  FOREIGN KEY ( post_id) REFERENCES post (id)
)";
$Connection->exec($sql5);

$sql6 = "CREATE TABLE if not EXISTS interaction (
  id INT PRIMARY KEY AUTO_INCREMENT ,
  value int,
  inserted_by INT,
  comment_id int ,
  FOREIGN KEY (inserted_by) REFERENCES users (id),
  FOREIGN KEY ( comment_id) REFERENCES comment (id)
)";
$Connection->exec($sql6);


$sql7 = "CREATE TABLE if not EXISTS admin (
   id INT PRIMARY KEY AUTO_INCREMENT ,
  first_name varchar(255),
  last_name varchar(255),
  email varchar(255) ,
  Password varchar(255),
  status tinyint
)";
$Connection->exec($sql7);

$sql8 = "CREATE TABLE if not EXISTS news (
  id INT PRIMARY KEY AUTO_INCREMENT ,
  title varchar(3000),
  content varchar(3000),
  inserted_by INT,
  inserted_date date,
  updated_by INT,
  updated_date DATE,
  status tinyint,
  image varchar(255),
  FOREIGN KEY (inserted_by) REFERENCES admin (id)
)";
$Connection->exec($sql8);

echo "You Are Conected to the date base ..";
?>
<?php
 include_once('../database/db_con.php');
 @session_start();

 if (!isset($_SESSION['username'])){
 	echo "<script>
          alert('Please Login! fitstly');
          window.location.href='../frontend/index.php';
        </script>";
 }
?>

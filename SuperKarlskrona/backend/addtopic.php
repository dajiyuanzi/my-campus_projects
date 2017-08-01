
<?php
include_once('../database/db_con.php');

@session_start();

//include_once('../public/login_check.php');
//$uid=$_SESSION['uid'];

if (!isset($_SESSION['username'])){
  echo "<script>alert('Please Login! fitstly');</script>";
}
else{
  if(isset($_POST['inputtext'])){
    if(isset($_COOKIE["setcookie".$_POST['inputtext'].""])){//judge cookie to prevent dupicate submission
      //echo "Have Done";
    } else {

  if(isset($_POST['inputtext'])&&!empty($_POST['inputtext'])){
    $topic=$_POST['inputtext'];

      $con->query("SET @return = ''");

      $sql = "CALL add_topic('" .$topic. "', '".$_SESSION['uid']."', @result);"; // add uid for user to view own bulletin board-Ji Yuan
      //echo $sql. "<br>";
      if ($con->query($sql) === TRUE) {

        $select = 'SELECT @result;';
        $res = $con->query($select);
        if ($res->num_rows > 0) {
          while($row = $res->fetch_assoc()) {
            echo "<p> ".$row["@result"]. "</p>";
          }
        } else {
          //echo "Error: " . $select . "<br>" . $con->error;
        }

      } else {
        //echo "Error: " . $select . "<br>" . $con->error;
      }

    setcookie("setcookie".$_POST['inputtext']."", "1", time()+72000000); //set cookie to prevent dupicate submission
  }



    }
  } else {
    //die('MySQL Error: ' . mysqli_error());
  }

}



?>

<link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
  <?php
   $sql="select `rid`, `address`, `description`, `contact` from room;";
    $result=$con->query($sql);

    //Display all available sharing
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){


        echo "<div class='adBox'>";
        echo "<p>Description: ".$row['description']."<br>";
        echo "Address - ".$row['address']." <br>";
        echo "Contact: ".$row['contact']."</p>";
        echo "</div><br>";

      }
    }
    else{
      echo "No adverts available";
    }
  ?>

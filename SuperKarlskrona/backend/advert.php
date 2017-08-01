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

        echo '  <div class="addapplybutton-'.$row['rid'].'">';


        $inbut = "$('.applyform-".$row['rid']."').css('display', 'block'); $('.addapplybutton-".$row['rid']."').css('display', 'none');";
        $but1  = '<button class=".addapplybutton-'.$row['rid'].'" onClick="'.$inbut.'">Apply</button>';

        echo $but1;
        echo ' <br><br>
          </div>
          <div style="width: 100%; display:none;" class="applyform-'.$row['rid'].'">
            <form action="../frontend/tenant.php?act=apply" name="applyform-'.$row['rid'].'" id="applyform-'.$row['rid'].'" method="post">
              <p>
                <label for="description" class="label">Description</label>
                <textarea form="applyform-'.$row['rid'].'" id="description" name="description" style="width:100%;"rows="4" cols="50"></textarea>
              <p/>
              <p>
                <label for="contact" class="label">Contact</label>
                <input style="width: 100%;" type="text" name="contact" class="left" />
              <p/>
              <p style="display: none;">
                <label style="display: none;" for="rid" class="label">Room ID</label>
                <input style="display: none;" type="text" name="rid" value="'.$row['rid'].'" class="left" />
              <p/>
              <p>
                  <input type="submit" value="Apply" name="Apply" class="left" />';

        $inbut2 = "$('.applyform-".$row['rid']."').css('display', 'none'); $('.addapplybutton-".$row['rid']."').css('display', 'block');";
        $but2  = ' <button type="cancel" onClick="'.$inbut2.'">Cancel</button>';

        echo $but2;

        echo "</p>
            </form>
        </div>
        </div><br>";

      }
    }
    else{
      echo "No adverts available";
    }
  ?>

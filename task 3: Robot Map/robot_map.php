<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Robot Map</title>
  </head>
  <body>
    <center>
      <h2>Robot Map</h2>
    </center>
    <div class="container">
      <div class="row">
        <!-- The left side -->
        <div class="col-md-4 firstCol">
          <!-- The first row -->
          <div class="row">
            <p>Select the direction and write the distance:</p>
            <h6><strong><span>*</span>Note: </strong>assume that 1 <i>m</i> equals to 20 pixels.</h6>
            <br>
            <form method="post" action="#" id="Myform">
              <!-- the direction and the distance-->
              <div class="input-group_style">
                <select name="direction" id="direction" class="selecton_style">
                  <option class="first_op"disabled selected>The Direction:</option>
                  <option  value="forwards">Forwards</option>
                  <option value="left">Left</option>
                  <option value="right">Right</option>
                </select>
              </div>
              <input type="number"id="dist" class="distance_input" placeholder="The Distance">
              <!-- the buttons-->
              <div class="buttons_style">
                <input type="submit" name="undo" id="undo" value="Delete" class="butn">
                <input type="submit" name="save" id="save" value="Save" onclick="passData()" class="butn">
                <input type="button" onclick="showpath()" name="draw" value="Draw" class="butn">
                 <input type="reset" name="reset" value="Reset" class="butn">
              </div>
            </form>
          </div>
          <!-- The second row -->
          <div class="row">
            <p class="path_style">The current path:</p>
          </div>
          <!-- The third row -->
          <div class="row">
            <p class="path_style_value" id="pathVal"></p>
          </div>
          <!-- The fourth row -->
          <div class="row">
            <!--=======================================-->
            <!-- Database Section: -->
            <!-- To save phaths and print it -->
            <!--=======================================--> 
            <?php
              if(isset($_POST["save"])){
                if(isset($_COOKIE['pathname']) && isset($_COOKIE['dir']) && isset($_COOKIE['dis'])){
              $path_name = $_COOKIE['pathname'];
              $r [] = $_COOKIE['dir'];
              $s [] = $_COOKIE['dis'];
              if (is_array($r) || is_object($r) || is_array($s) || is_object($s))
              {
              $spl_r = array();
              $spl_s = array();
              for ($i=0; $i < sizeof($r) ; $i++) { 
              $spl_r = preg_split("/[\s,]+/", $r[$i]);
              $spl_s = preg_split("/[\s,]+/", $s[$i]);
              }
              
              $full_path = array_combine($spl_r, $spl_s);
              
              require_once('connection.php');
              $onePath;
              foreach($full_path as $key => $value) {
              $onePath = $key.": ".$value." ";
              $q = "insert into task3 (path_name,path) values ('$path_name','$onePath')";
              $t = mysqli_query($conn,$q);
              }
              
              $p = "SELECT * from task3";
              $m = mysqli_query($conn,$p);
              $p_name = array();
              $full_p = array();
              if(mysqli_num_rows($m) > 0){
              echo '<h3 class="h3">THE SAVED PATHS</h3>';
              
              while ($row=mysqli_fetch_assoc($m)) {
              array_push($p_name, $row['path_name']);
              array_push($full_p, $row['path']);
              
              }//end loop
              $arr = array();
              for ($i = 0; $i < sizeof($full_p); $i++) {
                $p_Name = $p_name[$i];
              
                # If there is no array for the path name
                # then create a elemnt.
                if (!isset($arr[$p_Name])) {
                    $arr[$p_Name] = array();
                    $arr[$p_Name]['rowspan'] = 0;
                }
              
                $arr[$p_Name]['printed'] = "no";
              
                # Increment the row span value.
                $arr[$p_Name]['rowspan'] += 1;
              }
              echo "<table>";
              echo " <colgroup>";
              echo '<col span= "1" style="width: 10%;">';
              echo '<col span= "1" style="width: 30%;">';
              echo "</colgroup>";
              
              echo "<tr=>";
              echo "<th> Path Name </th>";
              echo "<th> The Path</th>";
              echo"<tr>";
              
              for($i=0; $i < sizeof($full_p); $i++) {
                $p_Name = $p_name[$i];
                echo "<tr>";
              
                # If this row is not printed then print.
                # and make the printed value to "yes", so that
                # next time it will not printed.
                if ($arr[$p_Name]['printed'] == 'no') {
                    echo "<td rowspan='".$arr[$p_Name]['rowspan']."'>".$p_Name."</td>";
                    $arr[$p_Name]['printed'] = 'yes';
                }
                echo "<td>".$full_p[$i]."</td>";
                echo "</tr>";
              }
              echo "</table>";
              
              
              }
              }//end second if 
              $conn->close();
              }//end first if
              }
              
              ?>
          </div>
        </div>
        <!-- end left side-->
        <!-- The right side -->
        <div id="drawindDiv"class="col-md-8 secondCol">
          <canvas id="c" width="760" height="510"></canvas>
        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
    <!--=======================================================-->
    <!-- JS -->
    <!--=======================================================-->
    <!--This script to show pahts and drow lines-->
    <script type="text/javascript">
      var i = 0;
      var dir =  Array();
      var dis = Array();
      var lastx = 0;
      var lasty = 0;
      var numDis = 0;
      
      function showpath(){
      
        dir[i] =  document.getElementById("direction").value;
        dis[i] = document.getElementById("dist").value;
        numDis = 20 * (parseInt(dis[i], 10));
        document.getElementById("pathVal").innerHTML += dir[i]+ ": " + dis[i]+" ";
       ctx = document.getElementById("c").getContext("2d");
         ctx.beginPath();
         if (i == 0){
          // pass start value
          if(dir[i] == "forwards"){
            // pass y value
            var yVal =  510 - numDis;
            canvas_arrow(ctx, 380, 510, 380, yVal);
            lastx = 380;
            lasty = yVal;
              
          }
          else{
            // pass x value
            if(dir[i] == "right"){
             var xVal = numDis + 380;
            canvas_arrow(ctx, 380, 510, xVal, 510);
             lastx = xVal;
            lasty = 510;
              
            }else{
            var xVal =  380 - numDis;
            canvas_arrow(ctx, 380, 510, xVal, 510);
             lastx = xVal;
            lasty = 510;
             
            }
          }
         }
         else{
            // ** pass last value:
            if(dir[i] == "forwards"){
      
           var yVal = lasty - numDis;
            canvas_arrow(ctx, lastx, lasty, lastx, yVal);
             
          }
           else{
            // pass x value
               if(dir[i] == "right"){
             var xVal = numDis + lastx;
            canvas_arrow(ctx, lastx, lasty, xVal, lasty);
            
            }else{
            var xVal = lastx - numDis;
            canvas_arrow(ctx, lastx, lasty, xVal, lasty);
               
            }
          }
         }
         
        
        i++;
        document.getElementById("direction").value = "";
        document.getElementById("direction").value = "";
      
        }
      function canvas_arrow(context, fromx, fromy, tox, toy) {
      lastx = tox;
      lasty = toy;
      
      var headlen = 20; // length of head in pixels
      var dx = tox - fromx;
      var dy = toy - fromy;
      var angle = Math.atan2(dy, dx);
      context.moveTo(fromx, fromy);
      context.lineTo(tox, toy);
      context.lineTo(tox - headlen * Math.cos(angle - Math.PI / 5), toy - headlen * Math.sin(angle - Math.PI / 5));
      context.moveTo(tox, toy);
      context.lineTo(tox - headlen * Math.cos(angle + Math.PI / 5), toy - headlen * Math.sin(angle + Math.PI / 5));
      context.lineCap = "round";
      context.lineWidth = 5;
      context.strokeStyle = '#dccdbc';
      context.stroke();
      }
    </script>
    <!--=======================================-->
    <!--This script to pass paths to php to stored in the database-->
    <script type="text/javascript">
      var message;
      var pathname;
      function passData(){
      
        if(dir[0] != null || dis[0] != null){
      
      var sure = confirm("Are you sure you want to save the current path?");
       
      if(sure){
      
      pathname = prompt("Please enter the path name:");
      if (pathname == null || pathname == "") {
      message = "You have to give a name to the current path to can save it.";
      } 
      
      else {
      document.cookie = "pathname = " + pathname;
      document.cookie = "dir = " + dir;
      document.cookie = "dis = " + dis;
      
      }
      }
      else{
      alert("it's okay!");
      }
        }
      else{
      alert("you should to enter a path to save it!");
      }
      
      }
    </script>
    <!--=======================================-->
    <!--This script to delete lines and paths-->
    <script type="text/javascript" rc="https://code.jquery.com/jquery-3.5.1.slim.min.js">
      'use strict';
      
      function updateButtons(history) {
        jQuery('#undo').attr('disabled',!history.canUndo());
      }
      
      function setEditorContents(contents) {
        jQuery('#c').val(contents);
      }
      
      jQuery(function(){
        var history = new SimpleUndo({
          maxLength: 200,
          provider: function(done) {
            done(jQuery('#c').val());
          },
          onUpdate: function() {
            
            if (!history) return; 
            
            updateButtons(history);
          }
        });
        
        jQuery('#undo').click(function() {
          history.undo(setEditorContents);
        });
      
        jQuery('#c').keypress(function() {
          history.save();
        });
        
        updateButtons(history);
      });
       
    </script>
    <!--=======================================-->
    <!-- ==================================================== -->          
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
    </script>
  </body>
</html>
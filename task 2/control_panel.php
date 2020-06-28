<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>control</title>
  </head>



  <body>
  <div class="container">
   <div class="row">
    <div class="col-md-4 firstCol">
        <center>
             <h3>The Control Panel</h3>
        </center>
     <br>
     <div class="row"> 
          <div class="col-md-2"> </div>
          <div class="col-md-8">
            <div class="ctrlDiv">
              <center> 
                <div>
                   <img class="contrl_img" src="control.png">
<form method="post" action="#" id="Myform">
  <input type="submit" name="Forwards" id="Forwards" value="" class="btn btnTop">
  <input type="submit" name="Left" id="Left" value="" class="btn btnLeft">
  <input type="submit" name="Stop" id="Stop" value="" class="btn btnStop">
  <input type="submit" name="Right" id="Right" value="" class="btn btnRight">
  <input type="submit" name="Backwards" id="Backwards" value="" class="btn btnBack">
</form>
                </div>
              </center>
              <br>
            </div>
               <br>   
          </div>
          <div class="col-md-2"></div>
        </div>

    </div>
    <div class="col-md-8 secondCol">
          <center>
             <h3>The Output Page</h3>
             <iframe src="output_page.php" style="height:200px;width:300px;border:none;"></iframe>
        </center>
        <br>
    </div>
   </div>
   
  </div>

<!--=======================================-->
 <!-- Data base -->
 <!-- Data base -->
 <?php 
if(array_key_exists('Forwards',$_POST)){
forward();
 
}
elseif(array_key_exists('Left',$_POST)){
left();
}
elseif(array_key_exists('Stop',$_POST)){
  stop();
}
elseif(array_key_exists('Right',$_POST)){
right();  
}
elseif(array_key_exists('Backwards',$_POST)){
 backwards(); 
}
else{
  echo "";
}

function forward(){
require_once('connection.php');
  $q = "insert into task2 (button_letter) values ('F')";
$t = mysqli_query($conn,$q);

}
function left(){
require_once('connection.php');
  $q = "insert into task2 (button_letter) values ('L')";
$t = mysqli_query($conn,$q);

}
function stop(){
require_once('connection.php');
  $q = "insert into task2 (button_letter) values ('S')";
$t = mysqli_query($conn,$q);

}
function right(){
require_once('connection.php');
  $q = "insert into task2 (button_letter) values ('R')";
$t = mysqli_query($conn,$q);

}
function backwards(){
require_once('connection.php');
  $q = "insert into task2 (button_letter) values ('B')";
$t = mysqli_query($conn,$q);

}
 ?>

</script-->
<!--=======================================================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js">
    </script>


  </body>
</html>
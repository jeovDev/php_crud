<?php
include 'connection.php';

session_start();
$id = $_SESSION['bkid']??'';
$book = $_POST['book']??'';
$author = $_POST['author']??'';
$cat = $_POST['category']??'';
$publish = $_POST['publish']??'';
if(isset($_POST['save'])){

  $sql = "UPDATE bookdb.book_tbl SET book = '$book', author='$author', publish='$publish', cat_id='$cat' WHERE book_id = $id";
  if($conn->query($sql)){
    header("location:index.php");
  }
}




 //Option Dropdown list
 $opt = "SELECT * FROM bookdb.cat_tbl";
 $optRes = $conn->query($opt);
//retrieve
$sql = "SELECT book_tbl.book, book_tbl.author,book_tbl.publish,book_tbl.book_id,book_tbl.cat_id,cat_tbl.cat_name FROM bookdb.book_tbl JOIN bookdb.cat_tbl ON book_tbl.cat_id = cat_tbl.cat_id WHERE  book_id = $id";

 $res = $conn->query($sql);


?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="edit.css" />
  </head>
  <body class="edit-body">
    <div class="header">Book Edit</div>
    <div class="container">
    <form method="POST">
    <div class="form-group row">
        <label for="example-text-input" class="col-2 col-form-label">
          Book ID : </label
        >
        <div class="col-10">
          <label class="form-control" ><?php  echo $_SESSION['bkid'];  ?></label>
        </div>
      </div>
      
     

     <?php
    
       while($data = $res->fetch_assoc())
       {
           $book = $data['book'];
           $cat = $data['cat_id'];
           $cat_name = $data['cat_name'];
           $author = $data['author'];
           $publish = $data['publish'];

      ?>


      <div class="form-group row">
        <label for="example-text-input" class="col-2 col-form-label">
          Title</label
        >
        <div class="col-10">
          <input class="form-control" type="text" id="example-text-input" name="book" value="<?php echo $book; ?>" />
        </div>
      </div>
      
      <div class="form-group row">
        <label for="example-search-input" class="col-2 col-form-label"
          >Author</label
        >
        <div class="col-10">
          <input class="form-control" type="search" id="example-search-input" name="author" value="<?php echo $author; ?>" />
        </div>
      </div>

     
   
      <div class="form-group row">
        <label for="example-search-input" class="col-2 col-form-label">Category</label>
        <div class="col-10">
        <select name="category" class="form-control">
        <option value="<?php echo $cat; ?>"> <?php echo $cat_name; ?> </option>
        <?php 
          while($row = $optRes->fetch_assoc()){
               $name = $row['cat_name'];
               $id = $row['cat_id'];
               echo "<option value=$id> $name </option>";
          }     
        ?>
         </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="example-date-input" class="col-2 col-form-label">Date</label>
        <div class="col-10">
          <input class="form-control" type="date" value="<?php echo $publish; ?>" id="example-date-input" name="publish" />
        </div>
      </div>

  
      <?php 
        }
      ?>

      <br />
      <br>
      
      <div class="form-group row">
         <input type="submit" class="btn-lg btn-block edit-btn" value="save" name="save">
      </div>
     
     
      </form>
   

    </div>

    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
      integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
      crossorigin="anonymous"
    ></script>
  </body>
</html>

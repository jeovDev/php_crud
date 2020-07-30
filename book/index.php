<?php
include 'connection.php';
$cat_name = $_POST['cat-name']??'';
// $name = "";
// $id = "";
session_start();
$book = $_POST['book']??'';
$author = $_POST['author']??'';
$publish = $_POST['publish']??'';
$cat_id = $_POST['cate']??'';

//Open Edit Page
if(isset($_POST['edit'])){

  $id = $_POST['book_id']??'';
  $_SESSION['bkid'] = $id;
  header("location:edit.php");
}
if(isset($_POST["btncat"])){

  if(!empty($cat_name)){  
      $sql =$conn->prepare("INSERT INTO bookdb.cat_tbl(cat_name)VALUE(?)");
      $sql->bind_param('s',$cat_name);
      $sql->execute();
      $cat_name = "";
      header("location:index.php");
  }
  }
//Delete Book
if(isset($_POST['delete'])){
  $id = $_POST['book_id']??'';
 $sql = "DELETE FROM bookdb.book_tbl WHERE book_id = $id";
 if($conn->query($sql) == TRUE){
  header("location:index.php");
 }
}
//Add Book
if(isset($_POST["btn-save"])){

  if($cat_id == 0){
     echo "Select Category";
  }
  else if(empty($book) || empty($author) )
  {
    echo "Contains Empty Field(s)";
  }
  else{ 
    $ver = "SELECT * FROM bookdb.book_tbl WHERE book = '$book' AND author='$author'";
    $res = $conn->query($ver);
    if($res->num_rows > 0){
      echo $book ." by ". $author ." already is in the database"; 
    }else{
      $sql = $conn->prepare("INSERT INTO bookdb.book_tbl(cat_id,book,author,publish)VALUES(?,?,?,?)");
      $sql->bind_param('ssss',$cat_id,$book,$author,$publish);
      $sql->execute();
    
      header("location:index.php");
    }
  }
}




 //Option Dropdown list
  $opt = "SELECT * FROM bookdb.cat_tbl";
  $optRes = $conn->query($opt);
  // Table data

    if(isset($_POST["search"])){
        $searchKEY = $_POST['searchkey']??'';
        $td = "SELECT book_tbl.book, book_tbl.author,book_tbl.publish,book_tbl.book_id,book_tbl.cat_id,cat_tbl.cat_name FROM bookdb.book_tbl JOIN bookdb.cat_tbl ON book_tbl.cat_id = cat_tbl.cat_id WHERE book LIKE '%$searchKEY%'";
       
    }
    else{
      $td = "SELECT book_tbl.book, book_tbl.author,book_tbl.publish,book_tbl.book_id,book_tbl.cat_id,cat_tbl.cat_name FROM bookdb.book_tbl JOIN bookdb.cat_tbl ON book_tbl.cat_id = cat_tbl.cat_id;";
      $tdRes = $conn->query($td);
      $searchKEY = "";
    }
    $tdRes = $conn->query($td);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
    <title>Document</title>
  </head>
  <body>
    <div class="header">Book</div>
    <div class="form-container">
   
      <div class="book-wrapper wrapper">

        <div class="book label">
          <label>Book</label>
        </div>
        <form method="POST">
        <div class="book-input input">
          <input type="text" name="book"/>
        </div>
      </div>

      <div class="author-wrapper wrapper">
        <div class="author label">
          <label>Author</label>
        </div>
        <div class="author-input input">
          <input type="text" name="author"/>
        </div>
      </div>

      <div class="category-wrapper wrapper">
        <div class="category label">
          <label>Category</label>
        </div>
        <div class="book-input input">
        <select name="cate">
        <option value="0"> Category ..  </option>
        <?php 
          while($row = $optRes->fetch_assoc()){
               $name = $row['cat_name'];
               $id = $row['cat_id'];
               echo "<option value=$id>$name </option>";
          }     
        ?>
         </select>
         <button type="button" class="add" data-toggle="modal" data-target="#exampleModal">
            +
          </button>
        </div>
      </div>

      <div class="publish-wrapper wrapper">
        <div class="publish label">
          <label>Publish</label>
        </div>
        <div class="book-input input">
          <input type="date" name="publish"/>
        </div>
      </div>
    </div>
    <div class="button-container">
      <!-- <button class="save" name="btn-save">Save</button> -->
      <input type="submit" class="save" name="btn-save" value="Save">
    </div>
    </form>
    <div class="search">
      <label for="">List of Books</label>
      <form method="post">
      <div class="search-wrapper">
      <input type="text"  class="search-field" name="searchkey" placeholder="Search Book Name" value="<?php echo $searchKEY;  ?>">
      <input type="submit" value=">>" class="btn-search" name="search" >
      </div>
      </form>
    </div>
    <div class="table-container">
      <table name="table">
        <tr>
        <th>ID</th>
        <th>Book</th>
        <th>Category</th>
        <th>Author</th>
        <th>Date Publish</th>
        <th>Edit</th>
        <th>Delete</th>
        </tr>
     
        <form method="GET">
         
          <td></td>
        <?php 
          while($rows = $tdRes->fetch_assoc()){
             
              
               echo "<tr>
               <td name='id'>" .$rows['book_id'] ."</td>
               <td>" . $rows['book'].  "</td>
               <td>" .$rows['cat_name']. " </td>
               <td>" .$rows['author'] . "</td>
               <td>" .$rows['publish'] . "</td>
              
              
               ";
          ?>
          </form>
          <form method="POST">     
             <td > 
             
             <!-- <button class = 'tblbtn edit'></button> -->
             <form action="POST" method="">
                <!-- <div class="btn"></div> -->
               <input type="submit" name="edit" class="del"/ value="Edit">
               <input type="hidden" name="book_id" value="<?php echo $rows['book_id']; ?>"  >
               <!-- <button class= 'tblbtn del' name='s'><img src='icon/delete.png' > </button>  -->
               
             
              </td>



               <td > 
                <form action="POST" method="">
                <!-- <div class="btn"></div> -->
               <input type="submit" name="delete" class="del"/ value="Delete">
               <input type="hidden" name="book_id" value="<?php echo $rows['book_id']; ?>"  >
               <!-- <button class= 'tblbtn del' name='s'><img src='icon/delete.png' > </button>  -->
               
               </form>
               
               </td>

            
          </form>
          <?php             
              echo " </tr>";                 
          }     
        ?>

             
      </table>
    </div>
   
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
    <?php 
  
    
    
    ?>


      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" name="x" > New Category</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
     
          <div class="modal-body">
          <form method="post">
            <input type="text" placeholder="Category" class="m-cat" name="cat-name"/> 
          </div>
          <div class="modal-footer">
          <input type="submit" class="m-save" value="Submit" name="btncat" >
          </form>
          </div>
      
        </div>
      </div>
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

<?php
  require "database.php";
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      color: white;
    }
    label, h2, h3, p {
      color: white;
    }
  </style>
</head>

<body>
  <br>
  
  <br><br><br><br>
  <div class="bigbox">
  <img src="Images\image1.png" class="corner-image" alt="Safwan">
    <div class="box1">
      <h2>Book Information</h2>
      <ul>
        <?php
          $query = "SELECT * FROM book";
          $result = mysqli_query($conn, $query);
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<p><h3>" ."Book Title, ISBN No., Author Name, No. of Books, Category =<br> ". implode(", ", $row) . "</li></h3>";
          }
        ?>
      </ul>
    </div>
    <div class="box2">
      <h2>Modify Information</h2>
      <br>
      <form action="" method="POST">
        <label for="delete">Delete ISBN:</label>
        <input type="text" name="createisbn">
        <input type="submit" name="createsubmit" value="Delete">
        <br><br><br>
      </form>
      <?php
        if(isset($_POST['createsubmit'])){
          $cisbn = trim($_POST['createisbn']);
          $deletequery = "DELETE FROM book WHERE isbn = '$cisbn'";
          if (mysqli_query($conn, $deletequery)) {
              echo "<p>Book deleted successfully.</p>";
              header("refresh:2;url=form.php");
          } else {
              echo "<p>Book delete unsuccessful: " . mysqli_error($conn) . "</p>";
          }
        }
      ?>

      <form action="" method="POST">
        <label for="update">Update ISBN:</label>
        <input type="text" name="updateisbn"><br><br>
        <label for="title">Title:</label>
        <input type="text" name="updatetitle"><br><br>
        <label for="author">Author:</label>
        <input type="text" name="updateauthor"><br><br>
        <label for="quantity">Quantity:</label>
        <input type="text" name="updatequantity"><br><br>
        <label for="category">Category:</label>
        <input type="text" name="updatecategory"><br><br>
        <input type="submit" name="updatesubmit" value="Update">
      </form>
      <?php
        if(isset($_POST['updatesubmit'])){
          $uisbn = trim($_POST['updateisbn']);
          $utitle = trim($_POST['updatetitle']);
          $uauthor = trim($_POST['updateauthor']);
          $uquantity = trim($_POST['updatequantity']);
          $ucategory = trim($_POST['updatecategory']);
          $updatequery = "UPDATE book SET name = '$utitle', author = '$uauthor', quantity = '$uquantity', category = '$ucategory' WHERE isbn = '$uisbn'";
          if (mysqli_query($conn, $updatequery)) {
              echo "<p>Book updated successfully.</p>";
              header("refresh:2;url=form.php");
          } else {
              echo "<p>Book update unsucsessfull: " . mysqli_error($conn) . "</p>";
          }
        }
        ?>
    </div>
    <div class="box3">
      <div class="box4">
      <h2>Tokens</h2>
      <ul>
        <?php
          $data = json_decode(file_get_contents('token.json')); 
          foreach($data[0]->token as $token){
              echo "<li>" . $token . "</li>";
          }
        ?>
      </ul>
      </div>
      
      <div class="box5">
      <h2 >Used tokens</h2>
      <ul>
        <?php
          $useddata = json_decode(file_get_contents('usedToken.json')); 
          foreach($useddata[0]->token as $token){
              echo "<li>" . $token . "</li>";
          }
        ?>
      </ul>
      </div>

    
    </div>

    <div class="box6">
      <img src="images/box6.jpg" width="100%" height="100%" alt="book cover 1">
    </div>
    <div class="box7">
      <img src="images/box7.jpg" width="100%" height="100%" alt="book cover 2">
    </div>
    <div class="box8">
      <img src="images/box8.jpg" width="100%" height="100%" alt="book cover 3">
    </div>
    <div class="box9">      
      <form action="process.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" placeholder="Name"/>
        <br><br>

        <label for="id">ID:</label>
        <input type="text" name="id" placeholder="ID"/>
        <br><br>

        <label for="email">Email:</label>
        <input type="text" name="email" placeholder="AIUB Mail"/>
        <br><br>

        <label for="book_title">Book Title:</label>
        <select name="book_title">
          <option value="A">Harry Potter</option>
          <option value="B">Sri Kanto</option>
          <option value="C">Hunger Games</option>
          <option value="D">Sherlock Holmes</option>
        </select>
        <br><br>

        <label for="borrow_date">Borrow Date:</label>
        <input type="date" name="borrow_date" placeholder="mm/dd/yyyy"/>
        <br><br>

        <label for="return-date">Return Date:</label>
        <input type="date" name="return_date" placeholder="mm/dd/yyyy"/>
        <br><br>

        <label for="token">Token:</label>
        <input type="text" name="token" placeholder="Valid token"/>
        <br><br>

        <label for="fees">Fees:</label>
        <input type="text" name="fees" placeholder="Amount"/>
        <br><br>

        <label for="paid">Paid:</label>
        <select name="paid">
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
        <br><br>

        <input type="submit" name="submit" value="Submit" />
      </form>
    </div>

    <div class="box10">
      <form action="book_process.php" method="POST">
        <label for="booktitle">Book Title:</label>
        <input type="text" name="booktitle" placeholder="Book Title">
        <br><br>
  
        <label for="Author">Author Name:</label>
        <input type="text" name="author" placeholder="Author Name">
        <br><br>
  
        <label for="ISBN_No">ISBN No:</label>
        <input type="text" name="isbn" placeholder="Valid ISBN">
        <br><br>
  
        <label for="Num_book">No. of Books:</label>
        <input type="text" name="num_book" placeholder="Total count">
        <br><br>
  
        <label for="Category">Category:</label>
        <input type="text" name="category" placeholder="category">
        <br><br><br>
        <input type="submit" name="submit2" value="Submit" />
      </form>
    </div>
    
  </div>
</body>

</html>
<?php
    require "database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <link rel="stylesheet" href="style.css">
    
</head>
<body>
        <h2>Receipt</h2>
            <?php
            $booktitle = trim($_POST['booktitle']);
            $author = trim($_POST['author']);
            $isbn = trim($_POST['isbn']);
            $num_book = trim($_POST['num_book']);
            $category = trim($_POST['category']);
            $error = false;

            if (empty($booktitle) || empty($author) || empty($isbn) || empty($num_book)) {
                echo "<p>Cannot be empty </p>";
                $error = true;
            }

            if (!preg_match("/[a-zA-Z\s]/", $author)) {
                echo "<p>Alphabets only</p>";
                $error = true;
            }
            if (!preg_match("/[0-9]/", $isbn)) {
                echo "<p>Numbers only </p>";
                $error = true;
            }
            if (!preg_match("/[0-9]/", $num_book)) {
                echo "<p>Numbers only</p>";
                $error = true;
            }

            if(!$error) {
                echo "<p>Book Title: $booktitle </p>";
                echo "<p>Author Name: $author </p>";
                echo "<p>ISBN No: $isbn </p>";
                echo "<p>Num. of Books: $num_book </p>";
                echo "<p>Category: $category </p>";
            }

            if(!$error){
                try{
                    if (isset($_POST['submit2'])){
                        $query = "INSERT INTO book(name, isbn, author, quantity, category) 
                                VALUES ('$booktitle', '$isbn', '$author', '$num_book', '$category')";
    
                        mysqli_query($conn, $query);
                        header("refresh:3;url=form.php");
                    }
                } catch (mysqli_sql_exception $ex){
                    echo "Error ".$ex->getMessage();
                }
            }
            

            ?>
</body>
</html>
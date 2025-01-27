<!DOCTYPE html>
<html lang="en">
<head>
   <link rel="stylesheet" href="style.css">
</head>
<body>
        <h2>Reciept</h2>
        <div class="body">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = trim($_POST['name']);
                $id = trim($_POST['id']);
                $email = trim($_POST['email']);
                $book_title = trim($_POST['book_title']);
                $borrow_date = trim($_POST['borrow_date']);
                $token = trim($_POST['token']);
                $return_date = trim($_POST['return_date']);
                $fees = trim($_POST['fees']);
                $paid = trim($_POST['paid']);
                $error = false;

                if (empty($name) || empty($id) || empty($book_title) || empty($borrow_date) || empty($token) || empty($return_date) || empty($fees) || empty($paid)) {
                        echo "<p>Fill all fields </p>";
                        $error = true;
                }

                if (!preg_match("/^[a-zA-Z.\s]+$/", $name)) {
                    echo "<p>Alphabets only</p>";
                    $error = true;
                }
                if (!preg_match("/^(18|19|20|21|22|23|24)-\d{5}-(1|2|3)$/", $id)) {
                    echo "<p>Aiub ID only </p>";
                    $error = true;
                }
                if (!preg_match("/^(18|19|20|21|22|23|24)-\d{5}-(1|2|3)+@+(student)+\.(aiub)+\.(edu)$/", $email)){
                    echo "<p>AIUB mail only </p>"; 
                    $error = true;
                }
                if (!preg_match("/\d+/", $fees)) {
                    echo "<p>Numbers only</p>";
                    $error = true;
                }

                $borrow_time = strtotime($borrow_date);
                $return_time = strtotime($return_date);
                $diff = ($return_time-$borrow_time) / (60*60*24);
                if ($return_time <= $borrow_time) {
                    echo "<p>Return date cannot be before or same as borrow date.</p>";
                    return;
                }

                if ($diff > 10) {
                    $data = json_decode(file_get_contents('token.json'));  
                    $validToken = false;
                    foreach($data[0]->token as $key => $value){
                        if($token == $value){
                            $validToken = true;
                            unset($data[0]->token[$key]);
                            break;
                        }
                    }
                    if ($validToken) {
                        $usedData = json_decode(file_get_contents('usedToken.json')); 
                        $usedData[0]->token[] = $token;
                        file_put_contents('usedToken.json', json_encode($usedData));
                        file_put_contents('Token.json', json_encode($data));
                    } else {
                        echo "<p>Invalid token.</p>";
                        $error = true;
                    }
                } else {
                    echo "<p> Borrow time $diff days </p>";
                    echo "<p> Token required to borrow for more than 10 days</p>";
                    $error = true;
                    return;
                }


                
                $cookieName = preg_replace('/\s+/', '', $book_title); 
                $cookieValue= preg_replace('/\s+/', '', $name);

                
                if (isset($_COOKIE[$cookieName]) && $_COOKIE[$cookieName] == $cookieValue) {
                    echo "<p>Book alraeady borrowed<br>Please try again after 10 days.</p>";
                    echo "<p><br><br>Returning to main page.</p>";
                    header("refresh:5;url=form.php");
                    $error = true;
                } else {
        
                    setcookie($cookieName, $cookieValue, time() + 10);
                    header("refresh:5;url=form.php");
                }
                

        
                if (!$error) {
                    echo "<p>Name: $name</p>";
                    echo "<p>ID: $id</p>";
                    echo "<p>Email: $email</p>";
                    echo "<p>Book Title: $book_title</p>";
                    echo "<p>Borrow Date: $borrow_date</p>";
                    echo "<p>Token: $token</p>";
                    echo "<p>Return Date: $return_date</p>";
                    echo "<p>Fees: $fees</p>";
                    echo "<p>Paid: $paid</p>";
                }
            }
            else {
                echo "<p>No data submitted.</p>";
            } 
            ?>
 </div>
</body>
</html>
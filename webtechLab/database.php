<?php
try{
    $conn = mysqli_connect(
        hostname: "localhost",
        username: "root",
        database: "lab"
    );
} catch (mysqli_sql_exception $ex){
    echo "Error ".$ex->getMessage();
}
?>
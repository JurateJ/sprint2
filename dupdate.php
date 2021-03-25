<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprint2</title>
    <link rel="stylesheet" type="text/css" href="./css/normalize.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
<?php

require_once './dbconnect.php';

// $id = $_GET['id']; 
if (isset($_GET['id']) && intval($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    $sql = "SELECT * FROM employees 
            WHERE id='$id'";
    $qry = mysqli_query($conn, $sql); // select query
    $row = mysqli_fetch_array($qry); // fetch data
    if(isset($_POST['update'])) // when click on Update button
    {
        $name = $_POST['name'];
        
        $edit = mysqli_query($conn,"UPDATE employees SET firstname='$name' WHERE id='$id'");
        if($edit)
        {
            mysqli_close($conn); // Close connection
            header("location:./?path=index.php"); // redirects 
            exit;
        }
        else
        {
            echo ("Error ". mysqli_error($link));
        }
    }
}
?>

<br>
<form method="POST" >
    <label for="firstname">Atnaujinkite DARBUOTOJO vardą:</label>
    <input type="text" name="name" id="firstname" value="<?php echo $row['firstname'] ?>" placeholder="Update Project Name" Required>
    <input type="submit" name="update" value="Atnauijinti" >
</form>
</body>
</html>
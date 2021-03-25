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

if (isset($_GET['id']) && intval($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    $sql = "SELECT * FROM employees 
            WHERE id='$id'";

    $qry = mysqli_query($conn, $sql); 
    $row = mysqli_fetch_array($qry); 
    if(isset($_POST['update'])) // jei paspaustas Update button
    {
        $name = $_POST['name'];
        $projektai= $_POST['id'];
        $edit = mysqli_query($conn,"UPDATE employees 
                                    SET firstname='$name', proj_id='$projektai'
                                    WHERE id='$id'");
        if($edit)
        {
            mysqli_close($conn); 
            header("location:./?path=index.php"); 
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
    <input type="text" name="name" id="firstname" value="<?php echo $row['firstname'] ?>" >

    <div>
        <label for="id">Pasirinkite projektą:</label>
        <select id="id" name="id">
            <?php
            $sql = "SELECT projektai.id, projektai.prpav 
                FROM projektai";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['prpav']; ?></option>
                    <?php 
                }
            } ?>
        </select>
    </div> 

    <input type="submit" name="update" value="Atnaujinti" >

</form>
</body>
</html>
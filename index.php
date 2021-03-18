<?php

    require_once './dbconnect.php';

    if (isset($_POST['create_empl'])) {
        $stmt = $conn->prepare("INSERT INTO employees (firstname, lastname) VALUES (?, ?)");
        $stmt->bind_param("ss", $firstname, $lastname);
        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
        var_dump($_POST);
        $stmt->execute();
        $stmt->close();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        die();
    }
    
    if(isset($_GET['action']) == 'delete'){
        $sql = 'DELETE FROM Employees WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $res = $stmt->execute();

        $stmt->close();
        mysqli_close($conn);

        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        die();
    }

?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" href="style.css">
    <title>Sprint2</title>
</head>
<body>

<header>
    <div>
      <br>
      <div>
            <a href="projektai.php" title="">Projektai</a>
            
            <a href="projektai.php" title="">Darbuotojai</a>
        </div>
      <br>    
    </div>

</header>
    <?php
        $sql = 'SELECT id, firstname, lastname FROM employees';
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            print('<table>');
            print('<thead>');
            print('<tr><th>Id</th><th>Vardas</th><th>Pavardė</th><th>Veiksmai</th></tr>');
            print('</thead>');
            print('<tbody>');
            while($row = mysqli_fetch_assoc($result)) {
                print('<tr>' 
                    . '<td>' . $row['id'] . '</td>' 
                    . '<td>' . $row['firstname'] . '</td>' 
                    . '<td>' . $row['lastname'] . '</td>'
                    . '<td>' . '<a href="?action=delete&id='  . $row['id'] . '"><button>DELETE</button></a>'
                    . ' ' 
                    . '<a href="?action=update&id='  . $row['id'] . '"><button>UPDATE</button></a>' . '</td>'
                    . '</tr>');
            }
            print('</tbody>');
            print('</table>');
        } else {
            echo '0 results';
        }
        mysqli_close($conn);
    ?>

<br>
<form action="" method="POST">
  <label for="fname">Įveskite darbuotojo vardą:</label><br>
  <input type="text" id="fname" name="fname" value="Jonas"><br>
  <label for="lname">Įveskite darbuotojo pavardę:</label><br>
  <input type="text" id="lname" name="lname" value="Donas"><br>
  <input type="submit" name="create_empl" value="Įvesti">
</form> 

</body>
</html>



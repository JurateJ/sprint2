<?php

    require_once './dbconnect.php';
  
    
    //create employee
    if (isset($_POST['create_empl'])) {
        $stmt = $conn->prepare("INSERT INTO employees (firstname) VALUES (?)");
        $stmt->bind_param("s", $firstname);
        $firstname = $_POST['fname'];
        var_dump($_POST);
        $stmt->execute();
        $stmt->close();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        die();
    }

    //delete employee   
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
            
            <a href="index.php" title="">Darbuotojai</a>
        </div>
      <br>    
    </div>

</header>

    <?php
        
        $sql = "SELECT employees.id, employees.firstname, projektai.prpav 
                FROM employees
                LEFT JOIN projektai 
                ON employees.proj_id = projektai.id 
                ORDER BY id";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            $counter = 1;
            print('<table>');
            print('<thead>');
            print('<tr><th>Nr.</th><th>Vardas</th><th>Dirba projekte</th><th>Veiksmai</th></tr>');
            print('</thead>');
            print('<tbody>');
            while($row = mysqli_fetch_assoc($result)) {
                print('<tr>' 
                    . '<td>' . $counter++ . '</td>' 
                    . '<td>' . $row['firstname'] . '</td>' 
                    . '<td>' . $row['prpav'] . '</td>' 
                    . '<td>' . '<a href="?action=delete&id='  . $row['id'] . '"><button>Ištrinti</button></a>'
                    . ' ' 
                    . '<a href="dupdate.php?id=' . $row['id'] . '"><button>Atnaujinti</button></a>
                       </td>'
                    . '</tr>'
                );
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
  <label for="fname">Įveskite NAUJO darbuotojo vardą:</label><br>
  <input type="text" id="fname" name="fname" size="28" value=""><br>
  <input type="submit" name="create_empl" value="Įvesti">
</form> 

</body>
</html>



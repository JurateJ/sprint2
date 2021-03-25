<?php

    require_once './dbconnect.php';
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // insert 
    if (isset($_POST['create_proj'])) {
        $stmt = $conn->prepare("INSERT INTO projektai (prpav) VALUES (?)");
        $stmt->bind_param("s", $prpav);
        $prpav = $_POST['fname'];
        // var_dump($_POST);
        $stmt->execute();
        $stmt->close();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        die();
    }
    
    //delete
    if(isset($_GET['action']) == 'delete'){
        $sql = 'DELETE FROM projektai WHERE id = ?';
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

        $sql = "SELECT projektai.id, projektai.prpav, group_concat(employees.firstname SEPARATOR ', ') 
                AS names
                FROM projektai
                LEFT JOIN employees ON projektai.id = employees.proj_id
                GROUP BY projektai.id";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $counter = 1;
            print('<table>');
            print('<thead>');
            print('<tr><th>Nr.</th><th>Projektas</th><th>Projekte dirba </th><th>Veiksmai</th></tr>');
            print('</thead>');
            print('<tbody>');
            while($row = mysqli_fetch_assoc($result)) {
                print('<tr>' 
                    . '<td>' . $counter++ . '</td>' 
                    . '<td>' . $row['prpav'] . '</td>'
                    . '<td>' . $row['names'] . '</td>'  
                    . '<td>' . '<a href="?action=delete&id='  . $row['id'] . '"><button>DELETE</button></a>'
                    . ' '
                    . '<a href="fupdate.php?id=' . $row['id'] . '"><button>UPDATE</button></a>
                       </td>'                   
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
  <label for="fname">Įveskite NAUJO projekto pavadinimą:</label><br>
  <input type="text" id="fname" name="fname" value=""><br>
  <input type="submit" name="create_proj" value="Įvesti">
</form> 
<br>

</body>
</html>



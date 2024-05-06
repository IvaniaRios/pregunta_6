<?php
session_start();
include_once "config.php";

if(isset($_SESSION['ci'])) {
    // Si el usuario ya está autenticado, redirigir a la página de inicio según su rol
    header("Location: index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $ci = $_POST['ci'];
    $ci2 = $_POST['ci2'];

    $sql = "SELECT * FROM persona WHERE ci = '$ci' and ci = '$ci2'";
    $result = $conn->query($sql);

    if($result->num_rows == 1) {
        // Usuario autenticado correctamente
        $row = $result->fetch_assoc();

        // Establecer variables de sesión
        $_SESSION['ci'] = $row['ci'];
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['c2'] = $row['c2'];

        // Redirigir a la página de inicio según el rol
        header("Location: index.php");
        exit;
    } else {
        // Credenciales incorrectas
        $error = "usuario o contraseña o contraseña incorrectos";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
   <hr>
   <div class="container">
   <h2>Iniciar sesión</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="ci">Usuario:</label><br>
        <input type="text" id="ci" name="ci" required><br>
        <label for="ci2">Contraseña:</label><br>
        <input type="password" id="ci2" name="ci2" required><br>
     <br>
        <input type="submit" class="btn btn-success" value="Iniciar sesión">
    </form>
    <?php if(isset($error)) { echo "<p>$error</p>"; } ?>
   </div>
</body>
</html>

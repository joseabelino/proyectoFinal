<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
  if(empty(trim($_POST["username"]))){
    $username_err = "Por favor ingrese su usuario.";
  } else{
    $username = trim($_POST["username"]);
  }

    // Check if password is empty
  if(empty(trim($_POST["password"]))){
    $password_err = "Por favor ingrese su contraseña.";
  } else{
    $password = trim($_POST["password"]);
  }

    // Validate credentials
  if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
      $param_username = $username;

            // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
                // Store result
        mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
          if(mysqli_stmt_fetch($stmt)){
            if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
              session_start();

                            // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;                            

                            // Redirect user to welcome page
              header("location: AT/index.php");
            } else{
                            // Display an error message if password is not valid
              $password_err = "La contraseña que has ingresado no es válida.";
            }
          }
        } else{
                    // Display an error message if username doesn't exist
          $username_err = "No existe cuenta registrada con ese nombre de usuario.";
        }
      } else{
        echo "Algo salió mal, por favor vuelve a intentarlo.";
      }
    }

        // Close statement
    mysqli_stmt_close($stmt);
  }

    // Close connection
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <style type="text/css">
    body{ font: 14px sans-serif; }
    .wrapper{ width: 350px; padding: 20px; }
  </style>
</head>
<body>
  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center">
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
          <div class="wrap d-md-flex">
            <div class="img" style="background-image: url(assets/images/bg-1.jpg);">
            </div>
            <div class="login-wrap p-4 p-md-5">
              <div class="d-flex">
                <div class="w-100">
                  <h3 class="mb-4">INICIAR SESIÓN</h3>
                </div>
              </div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="signin-form" method="post">
                <div class="form-group mb-3">
                  <label class="label" for="name">Usuario</label>
                  <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                  <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group mb-3">
                  <label class="label" for="password">Contraseña</label>
                  <input type="password" name="password" class="form-control">
                  <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary rounded submit px-3">Ingresar</button>
                  <br><br>
                  <p>¿No tienes una cuenta? <a href="register.php">Regístrate ahora</a>.</p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
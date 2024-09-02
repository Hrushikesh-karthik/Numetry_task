<?php
$login_success = false;

if (isset($_POST['email']) && isset($_POST['password'])) {
    $login_phone = $_POST['email'];
    $login_password = $_POST['password'];

    $server = "localhost";
    $username = "root";
    $password = "KARTHIK@2004";
    $database = "ziegler";
    $con = mysqli_connect($server, $username, $password, $database);

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    try {
        // Check if the user exists with the provided phone number
        $stmt = $con->prepare("SELECT * FROM intake WHERE email=?");
        $stmt->bind_param("s", $login_phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // User found, verify the password
            $row = $result->fetch_assoc();

            if (password_verify($login_password, $row['password'])) {
                $login_success = true;
                header("Location: /index.php");
                exit();
            } else {
                throw new Exception("Invalid password");
            }
        } else {
            throw new Exception("User not found");
        }
    } catch (Exception $e) {
        // Handle the exception
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    } finally {
        // Close the database connection
        mysqli_close($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        .m{
          
          border-radius: 10px;
            background: linear-gradient(skyblue,lightgreen);
              padding-left: 60px;
              width: 300px;
              height: auto;
              margin-left: 550px;
              margin-top: 200px;
              
              padding: 50px;
          }
          *{
              margin: 0px;
              padding: 0px;
          }
          input{
              display: block;
             margin-left: 30px;
             margin-top: 12px;
             width: 240px;
             padding: 6px;
             border-radius: 10px;
  
          }
          .bg{
              width:100%;
              position: absolute;
              z-index: -1;
              opacity: 0.6;
          }
          .v{
              margin-left: 100px;
              background-color:orange;
              color: black;
              padding: 4px;
              font-weight: bold;
              width: 100px;
              border-radius: 20px;
              font-size: 20px;
              margin-top: 10px;
          }
          h3{
  margin-left: 80px;
  font-size: 35px;
          }
          .z{
              color:orange;
              font-size: 40px;
              margin-left: 500px;
          }
    </style>
</head>
<body>
    <div class="m">
        <h3>Login</h3><br>
        <?php if ($login_success) : ?>
            <p>Login successful!</p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="Enter your Email" required><br>
            <input type="password" name="password" placeholder="Enter your password" required><br>
            <button type="submit" class="v">Signin</button>
        </form>
    </div>
</body>
</html>


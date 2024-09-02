<?php
session_start();
$insert = false;

if (isset($_POST['name'])) {
    $server = "localhost";
    $username = "root";
    $password = "KARTHIK@2004";
    $database = "ziegler";
    $con = mysqli_connect($server, $username, $password, $database);

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $college = $_POST['college'];
    $branch = $_POST['branch'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
   

    try {
       
$stmt = $con->prepare("INSERT INTO intake (name, email, phone, college, branch, address, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $email, $phone, $college, $branch, $address, $password);
$stmt->execute();
$insert = true;
$_SESSION["name"] = $username;
header("Location: login.php");
exit();


    } catch (Exception $e) {
        // Handle the exception
        echo "<p>Error: " . $e->getMessage() . "</p>";
    } finally {
        // Close the database connection
        mysqli_close($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Registration Form</title>
    <style>
        .box h1 {
            text-align: center;
            color: white;
            font-weight: bold;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        
        #emailPot {
            display: none;
        }

        .box {
            width: 500px;
            padding: 40px;
            position: absolute;
            margin-top: 300px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(45deg, #49a09d, #5f2c82);
        }
        .box label {
            font-size: 20px;
            color: white;
            font-weight: bold;
        }
        .box input,
        .box textarea,
        .box select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 2px solid #151414;
            outline: none;
        }
        .box .submit {
            width: 60%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
            outline: none;
            background: #16e312;
            color: white;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        .error-message {
            color: rgb(243, 3, 3);
            font-weight: bold;
            font-size: 21px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>Registration Form</h1>
        <form id="myForm" onsubmit="return validateForm()" action="regform.php" method="POST">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required>
            <div id="nameError" class="error-message"></div><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required>
            <div id="emailError" class="error-message"></div><br>
            
            <label for="phone">Phone:</label><br>
            <input type="tel" id="phone" name="phone" required>
            <div id="phoneError" class="error-message"></div><br>
            <label for="perc">College:</label><br>
            <input type="text" id="college" name="college" required>
            
            <label for="Branch">Branch:</label><br>
            <input type="text" id="branch" name="branch" required>
            
            <label for="address">Address:</label><br>
            <textarea name="address" id="address" rows="4" required></textarea>
            <div id="addressError" class="error-message"></div><br>
            <input type="text" name="emailPot" id="emailPot" style="display:none;">
            <label for="Password">Password:</label><br>
            <input type="password" id="password" name="password" required>
           
            <input type="submit" value="Submit" class="submit">
        </form>
    </div>
    <script>
    function validateForm() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("phone").value;
    var address = document.getElementById("address").value;
    var dob = document.getElementById("dob").value;
    var branch = document.getElementById("branch").value;
    var isValid = true;

    // Reset error messages
    document.getElementById("nameError").innerHTML = "";
    document.getElementById("emailError").innerHTML = "";
    document.getElementById("phoneError").innerHTML = "";
    document.getElementById("addressError").innerHTML = "";
    document.getElementById("dobError").innerHTML = "";
    document.getElementById("branchError").innerHTML = "";

    // Validation checks
    if (name === "") {
        document.getElementById("nameError").innerHTML = "Name is required";
        isValid = false;
    }
    if (email === "") {
        document.getElementById("emailError").innerHTML = "Email is required";
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(email)) {
        document.getElementById("emailError").innerHTML = "Invalid email format";
        isValid = false;
    }
    if (phone === "") {
        document.getElementById("phoneError").innerHTML = "Phone is required";
        isValid = false;
    } else if (!/^\d{10}$/.test(phone)) {
        document.getElementById("phoneError").innerHTML = "Phone number must be 10 digits";
        isValid = false;
    }
    if (branch === "") {
        document.getElementById("branchError").innerHTML = "Branch is required";
        isValid = false;
    }
    if (dob === "") {
        document.getElementById("dobError").innerHTML = "DOB is required";
        isValid = false;
    }
    if (address === "") {
        document.getElementById("addressError").innerHTML = "Address is required";
        isValid = false;
    }

    if (isValid) {
        saveToStorage();
        alert("Successfully Registered");
    }
    return isValid;
}

</script>
</body>
</html>

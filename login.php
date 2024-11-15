<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    // Retrieve input values
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the input is not empty
    if (!empty($email) && !empty($password)) {
        // Prepare the SQL query to fetch user details by email
        $stmt = $conn->prepare("SELECT id, email, password FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email); // Bind the email to the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Compare the entered password directly with the stored password
            if ($password === $user['password']) {
                // Start the session and store user information
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];

                // Redirect to the dashboard or another page
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    } else {
        $error = "Please enter both email and password.";
    }
}
?>

<!-- HTML Login Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <div class="logo-container">

            <img src="library_logo.jpeg" alt="Logo" class="logo">
        </div>
        <h2>Welcome Back</h2>

        <?php if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } ?>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>

</html>
<style>
    /* General reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body */
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #2c3e50 0%, #ACB6E5 100%);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        overflow: hidden;
    }

    /* Login container */
    .login-container {
        background: #fff;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
        text-align: center;
        transition: all 0.3s ease-in-out;
        background-color: #f9f9f9;
    }

    /* Logo container */
    /* Logo container with margin */
    .logo-container {
        margin-bottom: 30px;
        /* Space between logo and form */
        display: flex;
        justify-content: center;
        /* Center the logo horizontally */
    }

    /* Logo styling to make it a circle */
    .logo {
        width: 120px;
        /* Set the width */
        height: 120px;
        /* Set the height to match the width */
        border-radius: 50%;
        /* Make the logo circular */
        object-fit: cover;
        /* Ensure the logo image is properly fitted inside the circle */
    }


    /* Heading */
    h2 {
        font-size: 2rem;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Form elements */
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 15px;
        margin: 10px 0;
        border: 2px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
        font-size: 1rem;
        transition: all 0.3s ease-in-out;
    }

    /* Input focus */
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #2c3e50;
        outline: none;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }

    /* Buttons */
    button {
        width: 100%;
        padding: 15px;
        background: #2c3e50;
        border: none;
        color: white;
        font-size: 1.1rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    button:hover {
        background: #2c3e50;
        transform: scale(1.05);
    }

    button:active {
        background: #004085;
    }

    /* Error message */
    .error {
        color: #d9534f;
        font-size: 1rem;
        margin-top: 10px;
        padding: 10px;
        background-color: #f2dede;
        border: 1px solid #d9534f;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Responsive design */
    @media (max-width: 480px) {
        .login-container {
            padding: 20px;
            width: 100%;
            max-width: 300px;
        }

        h2 {
            font-size: 1.6rem;
        }

        input[type="email"],
        input[type="password"] {
            padding: 12px;
        }

        button {
            padding: 12px;
            font-size: 1rem;
        }
    }
</style>
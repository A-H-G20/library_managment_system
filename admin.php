<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit;
} ?>
<?php
include 'config.php';

$result = $conn->query("SELECT * FROM admin");

if (isset($_POST['add_admin'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];


    $conn->query("INSERT INTO admin (email, password ) VALUES ( '$email', '$password')");
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="library_logo.jpeg" rel="icon" />
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content p-4">
        <h2>Admin</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>

                    <th>Email</th>

                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>

                        <td><?php echo $row['email']; ?></td>


                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Add New Admin</h3>
        <form action="admin.php" method="post">

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="password">

            <button type="submit" name="add_admin">Add Admin</button>
        </form>
    </div>
</body>

</html>
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fb;
        margin: 0;
        padding: 0;
    }


    /* Main Content */
    .content {
        margin-left: 250px;
        padding: 30px;
        background-color: #fff;
        min-height: 100vh;
    }

    h2 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    /* Table Styling */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #007bff;
        color: white;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    /* Form Styling */
    form {
        display: flex;
        flex-direction: column;
        max-width: 400px;
        margin-top: 20px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    form input {
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    form input:focus {
        border-color: #007bff;
        outline: none;
    }

    form button {
        padding: 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #0056b3;
    }

    /* Error Message Styling */
    .alert {
        padding: 15px;
        margin-top: 20px;
        background-color: #f44336;
        color: white;
        border-radius: 4px;
    }

    .alert.success {
        background-color: #4CAF50;
    }
</style>
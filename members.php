<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit;
}

include 'config.php';

// Fetch members
$result = $conn->query("SELECT * FROM members");

// Handle member addition
if (isset($_POST['add_member'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $conn->query("INSERT INTO members (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')");
    header("Location: members.php");
    exit;
}

// Handle member deletion
if (isset($_POST['delete_member'])) {
    $member_id = $_POST['member_id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->close();

    header("Location: members.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Members</title>
    <link rel="stylesheet" href="style.css">
    <link href="library_logo.jpeg" rel="icon" />
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content p-4">
        <h2>Members</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Join Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['join_date']; ?></td>
                        <td>
                            <form action="members.php" method="post" style="display: inline;">
                                <input type="hidden" name="member_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_member">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Add New Member</h3>
        <form action="members.php" method="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone">
            <input type="text" name="address" placeholder="Address">
            <button type="submit" name="add_member">Add Member</button>
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

 
</style>
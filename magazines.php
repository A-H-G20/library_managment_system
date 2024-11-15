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

$result = $conn->query("SELECT * FROM magazines");

if (isset($_POST['add_magazine'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $issue_number = intval($_POST['issue_number']);
    $publication_date = $_POST['publication_date'];

    // Validate if publication date is in the correct format
    if (DateTime::createFromFormat('Y-m-d', $publication_date) !== false) {
        // Using prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO magazines (title, issue_number, publication_date) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $title, $issue_number, $publication_date);
        $stmt->execute();
        $stmt->close();

        // Redirect to the same page after successful insertion
        header("Location: magazines.php");
        exit();
    } else {
        $error_message = "Invalid date format. Please use YYYY-MM-DD.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Magazines</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content p-4">
        <h2>Magazines</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Issue Number</th>
                    <th>Publication Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['issue_number']; ?></td>
                        <td><?php echo $row['publication_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Add New Magazine</h3>
        <form action="magazines.php" method="post">
            <input type="text" name="title" placeholder="Title" required>
            <input type="number" name="issue_number" placeholder="Issue Number" required>
            <input type="date" name="publication_date" placeholder="Publication Date" required>
            <button type="submit" name="add_magazine">Add Magazine</button>
        </form>
    </div>
</body>

</html>
<style>
    /* Alert Styles */
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

    .alert.error {
        background-color: #f44336;
    }

    /* Form Styles (Existing) */
    form input,
    form button {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
    }

    form input[type="text"],
    form input[type="number"],
    form input[type="date"] {
        width: 100%;
        border: 1px solid #ccc;
    }

    form button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }

    form button:hover {
        background-color: #0056b3;
    }
</style>
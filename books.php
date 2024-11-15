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

$result = $conn->query("SELECT * FROM books");

if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'];
    $available_copies = $_POST['available_copies'];

    $conn->query("INSERT INTO books (title, author, genre, publication_year, available_copies) VALUES ('$title', '$author', '$genre', $publication_year, $available_copies)");
    header("Location: books.php");
}

// Delete book logic
if (isset($_GET['delete'])) {
    $book_id = $_GET['delete'];
    $conn->query("DELETE FROM books WHERE id = $book_id");
    header("Location: books.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Books</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="content p-4">
        <div class="dashboard-header">
            <h2>Books</h2>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Year</th>
                        <th>Available Copies</th>
                        <th>Actions</th> <!-- New Actions column -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['author']; ?></td>
                            <td><?php echo $row['genre']; ?></td>
                            <td><?php echo $row['publication_year']; ?></td>
                            <td><?php echo $row['available_copies']; ?></td>
                            <td>
                                <!-- Edit button -->
                                <a href="edit_book.php?id=<?php echo $row['id']; ?>">Edit</a> |
                                <!-- Delete button -->
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="add-book-form">
            <h3>Add New Book</h3>
            <form action="books.php" method="post">
                <input type="text" name="title" placeholder="Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <input type="text" name="genre" placeholder="Genre" required>
                <input type="number" name="publication_year" placeholder="Year" required>
                <input type="number" name="available_copies" placeholder="Available Copies" min="1" required>
                <button type="submit" name="add_book">Add Book</button>
            </form>
        </div>
    </div>
</body>

</html>
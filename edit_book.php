<?php
include 'config.php';

// Get the book ID from the URL
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch the current details of the book
    $result = $conn->query("SELECT * FROM books WHERE id = $book_id");

    // Check if the book exists
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found!";
        exit;
    }
} else {
    echo "No book ID provided!";
    exit;
}

// Update the book details
if (isset($_POST['update_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'];
    $available_copies = $_POST['available_copies'];

    // Update the book in the database
    $conn->query("UPDATE books SET title='$title', author='$author', genre='$genre', publication_year=$publication_year, available_copies=$available_copies WHERE id=$book_id");

    // Redirect to the books page after the update
    header("Location: books.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Edit Book</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content p-4">
        <div class="dashboard-header">
            <h2>Edit Book</h2>
        </div>

        <div class="add-book-form">
            <h3>Edit Book Details</h3>
            <form action="edit_book.php?id=<?php echo $book['id']; ?>" method="post">
                <input type="text" name="title" placeholder="Title" value="<?php echo $book['title']; ?>" required>
                <input type="text" name="author" placeholder="Author" value="<?php echo $book['author']; ?>" required>
                <input type="text" name="genre" placeholder="Genre" value="<?php echo $book['genre']; ?>" required>
                <input type="number" name="publication_year" placeholder="Year" value="<?php echo $book['publication_year']; ?>" required>
                <input type="number" name="available_copies" placeholder="Available Copies" value="<?php echo $book['available_copies']; ?>" min="1" required>
                <button type="submit" name="update_book">Update Book</button>
            </form>
        </div>
    </div>
</body>

</html>
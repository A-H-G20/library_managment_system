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

// Fetch issued books
$issuedBooks = $conn->query("SELECT issued_books.id, members.name AS member_name, books.title AS book_title, issued_books.issue_date, issued_books.return_date, issued_books.returned, issued_books.returned_date, books.id AS book_id
                             FROM issued_books
                             JOIN members ON issued_books.member_id = members.id
                             JOIN books ON issued_books.book_id = books.id");

// Fetch members
$members = $conn->query("SELECT id, name FROM members");

// Fetch available books
$books = $conn->query("SELECT id, title FROM books WHERE available_copies > 0");

// Handle issuing of books
if (isset($_POST['issue_book'])) {
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];

    // Ensure member and book IDs are valid
    if (is_numeric($member_id) && is_numeric($book_id)) {
        // Set the return date as 7 days from now
        $return_date = date('Y-m-d', strtotime('+7 days'));

        // Insert issued book record with the return date
        $stmt = $conn->prepare("INSERT INTO issued_books (member_id, book_id, return_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $member_id, $book_id, $return_date);
        $stmt->execute();

        // Decrease available copies of the book
        $stmt = $conn->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        // Redirect to avoid resubmission
        header("Location: issued.php");
        exit;
    } else {
        echo "Invalid member or book selection.";
    }
}

// Handle returning of books
if (isset($_POST['return_book'])) {
    $issued_book_id = $_POST['issued_book_id'];
    $book_id = $_POST['book_id'];

    // Get the current date for the return
    $returned_date = date('Y-m-d');

    // Mark the book as returned and set the returned date
    $stmt = $conn->prepare("UPDATE issued_books SET returned = 1, returned_date = ? WHERE id = ?");
    $stmt->bind_param("si", $returned_date, $issued_book_id);
    $stmt->execute();

    // Increase available copies of the book
    $stmt = $conn->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();

    // Redirect to avoid resubmission
    header("Location: issued.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Issued Books</title>
    <link rel="stylesheet" href="style.css">
    <link href="library_logo.jpeg" rel="icon" />
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content p-4">
        <h2>Issued Books</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Member</th>
                    <th>Book</th>
                    <th>Issue Date</th>
                    <th>Return Date</th>
                    <th>Returned</th>
                    <th>Returned Date</th>
                    <th>Action</th> <!-- New column for action buttons -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $issuedBooks->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['member_name']; ?></td>
                        <td><?php echo $row['book_title']; ?></td>
                        <td><?php echo $row['issue_date']; ?></td>
                        <td><?php echo $row['return_date']; ?></td>
                        <td>
                            <!-- Display "Yes" if returned, otherwise "No" -->
                            <?php echo $row['returned'] ? 'Yes' : 'No'; ?>
                        </td>
                        <td><?php echo $row['returned_date'] ? $row['returned_date'] : 'N/A'; ?></td>
                        <td>
                            <!-- Only show the "Return" button if the book hasn't been returned yet -->
                            <?php if (!$row['returned']): ?>
                                <form action="issued.php" method="post">
                                    <input type="hidden" name="issued_book_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="return_book" class="btn btn-danger">Return</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Issue New Book</h3>
        <form action="issued.php" method="post">
            <div class="form-group">
                <label for="member_id">Select Member</label>
                <select name="member_id" id="member_id" class="form-control" required>
                    <option value="">Select Member</option>
                    <?php while ($row = $members->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="book_id">Select Book</label>
                <select name="book_id" id="book_id" class="form-control" required>
                    <option value="">Select Book</option>
                    <?php while ($row = $books->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" name="issue_book" class="btn btn-primary">Issue Book</button>
        </form>
    </div>
</body>

</html>

<style>
    /* General Body Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }




    /* Content Styles */
    .content {
        margin-left: 260px;
        padding: 20px;
    }

    .content h2 {
        color: #343a40;
        margin-bottom: 20px;
    }

    .content h3 {
        margin-top: 40px;
        color: #495057;
    }

    /* Table Styles */
    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

    .table td {
        background-color: #f9f9f9;
    }

    .table tr:nth-child(even) td {
        background-color: #f2f2f2;
    }

    .table td:hover {
        background-color: #f1f1f1;
    }

    .table td:last-child {
        text-align: center;
    }

    /* Form Styles */
    form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-size: 16px;
        color: #343a40;
    }

    select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-top: 5px;
        background-color: #fafafa;
    }

    select:focus {
        border-color: #007bff;
        outline: none;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 12px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
    }

    button:hover {
        background-color: #0056b3;
    }

    /* Alert Messages */
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

    /* Footer Styles */
    footer {
        background-color: #343a40;
        color: white;
        padding: 15px;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
    }
</style>
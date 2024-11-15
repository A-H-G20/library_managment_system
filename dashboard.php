<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit;
} ?>
<?php
// Connect to the database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'library_web2';

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch counts from different tables
$books_count = $conn->query("SELECT COUNT(*) AS count FROM books")->fetch_assoc()['count'] ?? 0;
$members_count = $conn->query("SELECT COUNT(*) AS count FROM members")->fetch_assoc()['count'] ?? 0;
$admin_count = $conn->query("SELECT COUNT(*) AS count FROM admin")->fetch_assoc()['count'] ?? 0;
$magazines_count = $conn->query("SELECT COUNT(*) AS count FROM magazines")->fetch_assoc()['count'] ?? 0;
$issued_count = $conn->query("SELECT COUNT(*) AS count FROM issued_books")->fetch_assoc()['count'] ?? 0;
$returned_count = $conn->query("SELECT COUNT(*) AS count FROM issued_books WHERE returned = 1")->fetch_assoc()['count'] ?? 0;

$not_returned_count = $conn->query("SELECT COUNT(*) AS count FROM issued_books WHERE returned_date IS NULL")->fetch_assoc()['count'] ?? 0;
$date_today = date("m/d/Y");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Custom styles */
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }



        /* Main Content styles */
        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .content .row {
            margin-top: 20px;
        }

        .card {
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h3 {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 18px;
        }

        .card a {
            text-decoration: none;
            font-size: 14px;
            color: #fff;
            margin-top: 10px;
            display: block;
            transition: color 0.3s ease;
        }

        .card a:hover {
            color: #ecf0f1;
        }

        .card-blue {
            background-color: #007bff;
        }

        .card-green {
            background-color: #28a745;
        }

        .card-orange {
            background-color: #fd7e14;
        }

        .card-red {
            background-color: #dc3545;
        }

        .card-light-blue {
            background-color: #17a2b8;
        }

        .card-light-green {
            background-color: #6c757d;
        }
    </style>
</head>

<body>


    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard</h2>

        </div>
        <div class="row">
            <div class="col-md-3">
                <a href="books.php" class="card-link">
                    <div class="card card-blue">
                        <p>Books</p>
                        <h3><?php echo $books_count; ?></h3>

                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="members.php" class="card-link">
                    <div class="card card-green">
                        <p>Members</p>
                        <h3><?php echo $members_count; ?></h3>


                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="issued.php" class="card-link">
                    <div class="card card-orange">
                        <p>Issued</p>

                        <h3><?php echo $issued_count;; ?></h3>

                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="magazines.php" class="card-link">
                    <div class="card card-red">
                        <p>Magazines</p>
                        <h3><?php echo $magazines_count; ?></h3>


                    </div>
                </a>
            </div>


            <div class="col-md-3 mt-4">
                <a href="issued.php" class="card-link">
                    <div class="card card-blue">
                        <p>Returned</p>
                        <h3><?php echo $returned_count; ?></h3>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-4">
                <a href="admin.php" class="card-link">
                    <div class="card card-green">
                        <p>Admin</p>
                        <h3><?php echo $admin_count; ?></h3>


                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-4">
                <a href="issued.php" class="card-link">
                    <div class="card card-orange">
                        <p>Not Returned</p>
                        <h3><?php echo $not_returned_count; ?></h3>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-4">
                <div class="card card-red">
                    <p>Date Today</p>
                    <h3><?php echo $date_today; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
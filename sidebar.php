<style>
       /* Sidebar styles */
   .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background-color: #2c3e50;
            color: #fff;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar .header {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: #ecf0f1;
        }
        .sidebar .sidebar-profile {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar .sidebar-profile img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }
        .sidebar .sidebar-profile p {
            color: #ecf0f1;
            margin-top: 10px;
        }
        .sidebar .sidebar-links a {
            display: block;
            padding: 10px;
            color: #ecf0f1;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .sidebar .sidebar-links a:hover,
        .sidebar .sidebar-links a.active {
            background-color: #34495e;
            border-radius: 5px;
        }
        
</style>

<div class="sidebar">
    <div class="header">Library Management</div>
    <div class="sidebar-profile text-center my-3">
        <img src="library_logo.jpeg" alt="Profile Image" class="rounded-circle">
    </div>
    <div class="sidebar-links">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="books.php" class="active"><i class="fas fa-book"></i> Books</a>
        <a href="magazines.php"><i class="fas fa-newspaper"></i> Magazines</a>
        <a href="issued.php"><i class="fas fa-book-reader"></i> Issued</a>
        <a href="members.php"><i class="fas fa-users"></i> Members</a>
        <a href="admin.php"><i class="fas fa-users"></i> Admin</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

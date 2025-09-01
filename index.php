<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "db";
$username = "labuser";
$password = "labpass";
$dbname = "testdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the users table
$sql = "SELECT id, first_name, last_name, email, date_added FROM users";
$result = $conn->query($sql);

// HTML output with BootsWatch Spacelab theme
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users Table</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/quartz/bootstrap.min.css">
</head>
<body class="p-4">
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </li>
      </ul>
      <form class="d-flex" data-dashlane-rid="6ea751dd6f6b5b4d">
        <input class="form-control me-sm-2" type="search" placeholder="Search" data-dashlane-rid="6daeec6dfd18bc5f">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit" data-dashlane-label="true" data-dashlane-rid="17d6d162d2cbf1d4">Search</button>
      </form>
    </div>
  </div>
</nav>
    <div class="container">
        <h1 class="mb-4">Users</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Date Added</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['first_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['date_added']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container">
        <h1 class="mb-4">Trouble</h1>
        <p>Below are links that when clicked will cause trouble that we can then troubleshoot</p>
        <p>
          <a href="trouble.php?mode=db&seconds=20">Run DB stress (20s)</a> |
          <a href="trouble.php?mode=cpu&seconds=20">Run CPU stress (20s)</a>
        </p>
    </div>
</body>
</html>
<?php
$conn->close();
?>


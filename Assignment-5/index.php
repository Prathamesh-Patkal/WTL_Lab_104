<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert Employee
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $hire_date = $_POST['hire_date'];
    
    if ($conn->query("INSERT INTO employees (name, email, position, salary, department, phone, address, hire_date) 
    VALUES ('$name', '$email', '$position', '$salary', '$department', '$phone', '$address', '$hire_date')")) {
        echo "<script>alert('Employee added successfully!'); window.location.href='index.php';</script>";
    }
}

// Delete Employee
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("DELETE FROM employees WHERE id=$id")) {
        echo "<script>alert('Employee deleted successfully!'); window.location.href='index.php';</script>";
    }
}

// Fetch Employee Data for Editing
$edit_state = false;
$edit_id = "";
$edit_name = "";
$edit_email = "";
$edit_position = "";
$edit_salary = "";
$edit_department = "";
$edit_phone = "";
$edit_address = "";
$edit_hire_date = "";

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM employees WHERE id=$edit_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_state = true;
        $edit_name = $row['name'];
        $edit_email = $row['email'];
        $edit_position = $row['position'];
        $edit_salary = $row['salary'];
        $edit_department = $row['department'];
        $edit_phone = $row['phone'];
        $edit_address = $row['address'];
        $edit_hire_date = $row['hire_date'];
    }
}

// Update Employee
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $hire_date = $_POST['hire_date'];

    if ($conn->query("UPDATE employees SET name='$name', email='$email', position='$position', salary='$salary', 
    department='$department', phone='$phone', address='$address', hire_date='$hire_date' WHERE id=$id")) {
        echo "<script>alert('Employee updated successfully!'); window.location.href='index.php';</script>";
    }
}

// Fetch all employees
$employees = $conn->query("SELECT * FROM employees");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Employee Management System</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $edit_id ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?= $edit_name ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?= $edit_email ?>" required>
            <label>Position:</label>
            <input type="text" name="position" value="<?= $edit_position ?>" required>
            <label>Salary:</label>
            <input type="number" name="salary" value="<?= $edit_salary ?>" required>
            <label>Department:</label>
            <select name="department" required>
                <option value="HR" <?= $edit_department == 'HR' ? 'selected' : '' ?>>HR</option>
                <option value="IT" <?= $edit_department == 'IT' ? 'selected' : '' ?>>IT</option>
                <option value="Finance" <?= $edit_department == 'Finance' ? 'selected' : '' ?>>Finance</option>
                <option value="Marketing" <?= $edit_department == 'Marketing' ? 'selected' : '' ?>>Marketing</option>
            </select>
            <label>Phone:</label>
            <input type="text" name="phone" value="<?= $edit_phone ?>" required>
            <label>Address:</label>
            <input type="text" name="address" value="<?= $edit_address ?>" required>
            <label>Hire Date:</label>
            <input type="date" name="hire_date" value="<?= $edit_hire_date ?>" required>
            <?php if ($edit_state): ?>
                <button type="submit" name="update">Update</button>
            <?php else: ?>
                <button type="submit" name="add">Add</button>
            <?php endif; ?>
            <button type="button" id="toggleDisplay">Display Records</button>
        </form>
        
        <div id="records">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Department</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Hire Date</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $employees->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['position'] ?></td>
                    <td><?= $row['salary'] ?></td>
                    <td><?= $row['department'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['hire_date'] ?></td>
                    <td class="actions">
                        <a href="?edit=<?= $row['id'] ?>">Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    
    <script>
        document.getElementById('toggleDisplay').addEventListener('click', function() {
            var recordsDiv = document.getElementById('records');
            recordsDiv.style.display = (recordsDiv.style.display === 'none' || recordsDiv.style.display === '') ? 'block' : 'none';
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>

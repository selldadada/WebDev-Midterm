<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="DashboardCSS.css">
</head>

<body>
  
    <!-- for header part -->
    <header>
        <div class="logosec">
            <div class="logo">Employee Dashboard</div>
        </div>

        <div class="searchbar">
            <input type="text" placeholder="Search">
            <div class="searchbtn">
              <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210180758/Untitled-design-(28).png"
                   class="icn srchicn" alt="search-icon">
            </div>
        </div>
    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <div class="nav-option option1">
                        <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                             class="nav-img" alt="dashboard">
                        <h3> Dashboard</h3>
                    </div>
                    <div class="nav-option logout" id="logoutDiv" onclick="logout()">
    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210183321/7.png"
         class="nav-img" alt="logout">
    <h3>Logout</h3>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button onclick="confirmLogout()">Yes</button>
        <button onclick="closeModal()">No</button>
    </div>
</div>
                </div>
            </nav>
        </div>
        
        <div class="main">
            <div class="searchbar2">
                <input type="text" name="" id="" placeholder="Search">
                <div class="searchbtn">
                  <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210180758/Untitled-design-(28).png"
                       class="icn srchicn" alt="search-button">
                </div>
            </div>

            <div class="box-container">
                <div class="box box1" onclick="showAddEmployeeModal()">
    <div class="text">
        <h2>Add Employee</h2>
    </div>
    <img src="https://png.pngtree.com/png-vector/20190425/ourmid/pngtree-vector-add-icon-png-image_987463.jpg" alt="Views">
</div>
                
                <!-- Add Employee Form Modal -->
<div id="addEmployeeModal" class="modal">
    <div class="modal-content">
        <h3>Add Employee</h3>
        <form id="addEmployeeForm">
            <label for="empName">Employee Name:</label>
            <input type="text" id="empName" name="empName" maxlength="41"required>

            <label for="empSalary">Employee Salary:</label>
            <input type="int" id="empSalary" name="empSalary" min="0" maxlength="20" required>

            <button type="button" onclick="addEmployee()">Add</button>
            <button type="button" onclick="closeAddEmployeeModal()">Cancel</button>
        </form>
    </div>
</div>

                <div class="box box2">
                    <div class="text">
                        <h2>Update Employee Salary</h2>
                    </div>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT6pEOUP2fjgW8la8zKcrb3W6-RcUPq4eeXag&s" alt="likes">
                </div>

                <div class="box box3">
                    <div class="text">
                        <h2>Delete Employee</h2>
                    </div>
                    <img src="https://cdn-icons-png.flaticon.com/512/3550/3550701.png" alt="comments">
                </div>
            </div>

            <div class="report-container">
    <div class="report-header">
        <h1 class="recent-Articles">Employee List</h1>
    </div>

    <div class="report-body">
    <table>
        <thead>
            <tr>
                <th class="t-op">Employee ID</th>
                <th class="t-op">Full Name</th>
                <th class="t-op">Salary</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection
            $host = 'localhost';
            $username = 'root';
            $password = ''; 
            $dbname = 'db_portal';

            // Create connection
            $conn = new mysqli($host, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to fetch employee data
            $sql = "SELECT * FROM tbl_employee";
            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["emp_ID"]) . "</td>
                            <td>" . htmlspecialchars($row["emp_name"]) . "</td>
                            <td>" . htmlspecialchars($row["emp_Salary"]) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No Records Found.</td></tr>";
            }
            
            // Check if the POST variables are set
if (isset($_POST['empName']) && isset($_POST['empSalary'])) {
    $empName = $conn->real_escape_string($_POST['empName']);
    $empSalary = $conn->real_escape_string($_POST['empSalary']);

    // Insert the new employee record
    $sql = "INSERT INTO tbl_employee (emp_name, emp_Salary) VALUES ('$empName', '$empSalary')";

    if ($conn->query($sql) === TRUE) {
        echo "Employee added successfully!";
    } else {
        echo "Invalid input.";
    }
}


            // Close the connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

                </div>
            </div>
        </div>
    </div>

    <script src="DashboardJS.js"></script>

</body>
</html>
   
function logout() {
        // Display the modal when the logout div is clicked
        document.getElementById("logoutModal").style.display = "flex";
    }

    function closeModal() {
        // Hide the modal when the 'No' button is clicked
        document.getElementById("logoutModal").style.display = "none";
    }

    function confirmLogout() {
        // Redirect to login page or perform logout action
        window.location.href = "login.php";
    }

    // Hide modal by default in case of page reload or other JS interference
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("logoutModal").style.display = "none";
    });
    
    
//Add employee
// Show the Add Employee form
function showAddEmployeeModal() {
    document.getElementById("addEmployeeModal").style.display = "flex";
}

// Close the Add Employee form
function closeAddEmployeeModal() {
    document.getElementById("addEmployeeModal").style.display = "none";
}

// Add employee to the table
function addEmployee() {
    const name = document.getElementById("empName").value;
    const salary = document.getElementById("empSalary").value;

    if (name && salary) {
        // Add the new employee to the table
        const table = document.querySelector("table tbody");
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>New</td> <!-- Placeholder ID; can be replaced with actual ID logic -->
            <td>${name}</td>
            <td>${salary}</td>
        `;
        table.appendChild(newRow);

        // Clear the form fields
        document.getElementById("empName").value = "";
        document.getElementById("empSalary").value = "";

        // Close the modal
        closeAddEmployeeModal();
    } else {
        alert("Please fill out all fields");
    }
}

//add employee
function addEmployee() {
    const empName = document.getElementById('empName').value;
    const empSalary = document.getElementById('empSalary').value;

    if (empName && empSalary) {
        // Create an AJAX request to add_employee.php
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_employee.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = xhr.responseText;
                alert(response); // Show success or failure message
                closeAddEmployeeModal(); // Close the modal
                location.reload(); // Reload page to update the employee list
            }
        };
        xhr.send(`empName=${empName}&empSalary=${empSalary}`);
    } else {
        alert("Please fill out both fields.");
    }
}

// This function will be called only when the user clicks the "Add Employee" box
document.addEventListener("DOMContentLoaded", () => {
    // Hide modal by default in case of page reload or other JS interference
    document.getElementById('addEmployeeModal').style.display = 'none';

    // Ensure that clicking the "Add Employee" box shows the modal
    document.querySelector('.box1').addEventListener('click', showAddEmployeeModal);
});
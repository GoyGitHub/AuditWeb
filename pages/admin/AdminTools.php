<?php
include('../../database/dbconnection.php');

// Handle Add Personnel (Agent, Auditor, Supervisor, Data Analyst)
if (isset($_POST['add_person'])) {

    $roleType = $_POST['role_type'] ?? '';
    $msg = "";
    $error = "";

    // Helper function for required field validation
    function validate_fields($fields) {
        foreach ($fields as $field => $value) {
            if (empty(trim($value))) {
                return "The field '$field' is required.";
            }
        }
        return '';
    }

    if ($roleType === "agent") {
        $fields = [
            'First Name' => $_POST['agent_firstname'] ?? '',
            'Last Name' => $_POST['agent_lastname'] ?? '',
            'Birthday' => $_POST['agent_birthday'] ?? '',
            'Email' => $_POST['agent_email'] ?? '',
            'Team' => $_POST['agent_team'] ?? ''
        ];
        $error = validate_fields($fields);

        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO agents (agent_firsttname, agent_lastname, birthday, email, team) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssss",
                $_POST['agent_firstname'], // mapped to DB column agent_firsttname
                $_POST['agent_lastname'],
                $_POST['agent_birthday'],
                $_POST['agent_email'],
                $_POST['agent_team']
            );
            $msg = "Agent";
        }

    } elseif ($roleType === "auditor") {
        $fields = [
            'First Name' => $_POST['auditor_firstname'] ?? '',
            'Last Name' => $_POST['auditor_lastname'] ?? '',
            'Birthday' => $_POST['auditor_birthday'] ?? '',
            'Email' => $_POST['auditor_email'] ?? '',
            'Department' => $_POST['auditor_department'] ?? ''
        ];
        $error = validate_fields($fields);

        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO auditors2 (auditor_firstname, auditor_lasttname, birthday, email, department) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssss",
                $_POST['auditor_firstname'],
                $_POST['auditor_lastname'], // mapped correctly to DB column auditor_lasttname
                $_POST['auditor_birthday'],
                $_POST['auditor_email'],
                $_POST['auditor_department']
            );
            $msg = "Auditor";
        }

    } elseif ($roleType === "supervisor") {
        $fields = [
            'First Name' => $_POST['supervisor_firstname'] ?? '',
            'Last Name' => $_POST['supervisor_lastname'] ?? '',
            'Birthday' => $_POST['supervisor_birthday'] ?? '',
            'Email' => $_POST['supervisor_email'] ?? '',
            'Team' => $_POST['supervisor_team'] ?? ''
        ];
        $error = validate_fields($fields);

        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO supervisors (supervisor_firstname, supervisor_lastname, birthday, email, team) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssss",
                $_POST['supervisor_firstname'],
                $_POST['supervisor_lastname'],
                $_POST['supervisor_birthday'],
                $_POST['supervisor_email'],
                $_POST['supervisor_team']
            );
            $msg = "Supervisor";
        }

    } elseif ($roleType === "data_analyst") {
        $fields = [
            'First Name' => $_POST['data_analyst_firstname'] ?? '',
            'Last Name' => $_POST['data_analyst_lastname'] ?? '',
            'Birthday' => $_POST['data_analyst_birthday'] ?? '',
            'Email' => $_POST['data_analyst_email'] ?? '',
            'Department' => $_POST['data_analyst_department'] ?? ''
        ];
        $error = validate_fields($fields);

        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO data_analysts (data_analyst_firstname, data_analyst_lastname, birthday, email, department) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssss",
                $_POST['data_analyst_firstname'],
                $_POST['data_analyst_lastname'],
                $_POST['data_analyst_birthday'],
                $_POST['data_analyst_email'],
                $_POST['data_analyst_department']
            );
            $msg = "Data Analyst";
        }

    } else {
        $error = "Invalid role type selected.";
    }

    // Execute if no validation errors
    if (!$error && isset($stmt)) {
        if ($stmt->execute()) {
            echo "<script>alert('✅ $msg added successfully!');</script>";
        } else {
            echo "<script>alert('❌ Error adding $msg: " . addslashes($conn->error) . "');</script>";
        }
        $stmt->close();
    } elseif ($error) {
        echo "<script>alert('❌ $error');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!--=============== GOOGLE FONT ===============-->
   <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">

   <!--=============== REMIXICONS ===============-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

   <!--=============== CSS ===============-->
   <link rel="stylesheet" href="../../assets/css/styles.css">

   <title>Dashboard | Cool Pals</title>

   <style>
.dashboard-article {
    padding: 2.5rem;
    background-color: #fff;
    border-radius: 1rem;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    margin-top: 2.5rem;
    font-family: 'Nunito Sans', sans-serif;
}

.dashboard-article h2 {
    font-size: 2rem;
    color: #003366;
    margin-bottom: 1.5rem;
}

.dashboard-article p {
    font-size: 1rem;
    line-height: 1.8;
    color: #333;
    margin-bottom: 1.8rem;
}

.dashboard-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 2.7rem;
    margin-top: 1.5rem;
}

.dashboard-buttons a {
    padding: 2.5rem 7rem;
    background-color: #003366;
    color: #fff;
    text-decoration: none;
    border-radius: 1rem;
    transition: 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 6rem;
    font-weight: 500;
}

.dashboard-buttons a:hover {
    background-color: #0055aa;
}

.dashboard-buttons i {
    font-size: 1.3rem;
}

/* Slideshow Styles */
.slideshow-container {
    position: relative;
    max-width: 100%;
    height: 550px;
    margin: 25px auto;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
}

.slide {
    display: none;
    height: 100%;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 1rem;
}

.fade {
    animation: fadeEffect 1.5s;
}

@keyframes fadeEffect {
    from {opacity: 0.4}
    to {opacity: 1}
}

/* Dots (Indicators) */
.dots {
    text-align: center;
    margin-top: 15px;
}

.dot {
    height: 14px;
    width: 14px;
    margin: 0 5px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.3s;
    cursor: pointer;
}

.active-dot {
    background-color: #003366;
}

/* Modal Styles */
.modal {
    display: none; /* hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.65);

    /* Make it flex when opened */
    display: none;
    justify-content: center;
    align-items: center;
}


.modal-content {
    background: #fff;
    padding: 3rem;
    border-radius: 12px;
    width: 620px;
    max-width: 95%;
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
    animation: fadeIn 0.3s ease-in-out;
    text-align: center;
}

.close {
    float: right;
    font-size: 1.9rem;
    font-weight: bold;
    cursor: pointer;
    color: #555;
    margin-top: -12px;
}

.close:hover {
    color: red;
}

.modal-content h2 {
    margin-bottom: 2rem;
    font-size: 1.7rem;
    color: #003366;
}

/* Form inside modal */
.modal-content form {
    display: flex;
    flex-direction: column;
    gap: 1.8rem;
    align-items: stretch;
}

.modal-content input,
.modal-content select {
    width: 100%;
    padding: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    text-align: left;
    margin-bottom: 4px;
}

.modal-content button {
    padding: 16px;
    margin-top: 10px;
    background: #003366;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: 0.3s;
}

.modal-content button:hover {
    background: #0055aa;
}

/* Show Password checkbox */
.show-password {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
    margin: 10px 0 14px 2px;
    font-size: 14px;
    color: #333;
}

.show-password input[type="checkbox"] {
    transform: scale(1.2);
    cursor: pointer;
    margin: 0;
}

/* Modal Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

   </style>

</head>
<!--=============== HEADER ===============-->
<header class="header" id="header">
   <div class="header__container">
      <button class="header__toggle" id="header-toggle">
         <i class="ri-menu-line"></i>
      </button>

      <!-- Right-side Logo Link -->
      <a href="https://yourlink.com" class="header__logo">
         <img src="../../assets/img/logo.png" alt="Logo" style="height: 40px;">
      </a>
   </div>
</header>

   <!--=============== SIDEBAR ===============-->
   <nav class="sidebar" id="sidebar">
      <div class="sidebar__container">
         <div class="sidebar__user">
            <div class="sidebar__img">
               <img src="../../assets/img/perfil.png" alt="image">
            </div>

            <div class="sidebar__info">
               <h3>Jhayvot G.</h3>
               <span>Administrator</span>
            </div>
         </div>

         <div class="sidebar__content">
            <div>
               <h3 class="sidebar__title">MANAGE</h3>
               <div class="sidebar__list">
                  <a href="AdminDashboard.php" class="sidebar__link">
                     <i class="ri-dashboard-horizontal-fill"></i>
                     <span>Dashboard</span>
                  </a>
                  <a href="AdminAuditDatabank.php" class="sidebar__link">
                     <i class="ri-database-fill"></i> 
                     <span>UCX Data Bank</span>
                  </a>
                  <a href="#" class="sidebar__link">
                     <i class="ri-ubuntu-fill"></i>
                     <span>UCX Connect</span>
                  </a>
                  <a href="AdminAuditForm.php" class="sidebar__link">
                     <i class="ri-survey-fill"></i>
                     <span>Unify Audit System (UAS)</span>
                  </a>
                  <a href="AdminHrRecords.php" class="sidebar__link">
                     <i class="ri-folder-history-fill"></i>
                     <span>HR Records</span>
                  </a>
               </div>
            </div>

            <div>
               <h3 class="sidebar__title">TOOLS</h3>
               <div class="sidebar__list">
                  <a href="AdminTools.php" class="sidebar__link active-link ">
                     <i class="ri-settings-3-fill"></i>
                     <span>Admin Tools</span>
                  </a>
                  <a href="#" class="sidebar__link">
                     <i class="ri-mail-unread-fill"></i>
                     <span>My Messages</span>
                  </a>
                  <a href="#" class="sidebar__link">
                     <i class="ri-notification-2-fill"></i>
                     <span>Notifications</span>
                  </a>
               </div>
            </div>
         </div>

         <div class="sidebar__actions">
            <button>
               <i class="ri-moon-clear-fill sidebar__link sidebar__theme" id="theme-button">
                  <span>Theme</span>
               </i>
            </button>
            <a href="../../LoginFunction.php" class="sidebar__link">
               <i class="ri-logout-box-r-fill"></i>
               <span>Log Out</span>
            </a>
         </div>
      </div>
   </nav>

   <!--=============== MAIN ===============-->
   <main class="main container" id="main">
      <section class="dashboard-article">
         <h2>Welcome to UCX Overview</h2>

         <!-- Slideshow Section -->
         <div class="slideshow-container">
            <div class="slide fade">
               <img src="../../assets/img/1.jfif" alt="Slideshow Image 1">
            </div>
            <div class="slide fade">
               <img src="../../assets/img/2.jfif" alt="Slideshow Image 2">
            </div>
            <div class="slide fade">
               <img src="../../assets/img/3.jfif" alt="Slideshow Image 3">
            </div>
         </div>

         <!-- Dots (Indicators) -->
         <div class="dots">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
         </div>

<div class="dashboard-buttons">
    <a href="#" onclick="openAccountModal()">
        <i class="ri-user-add-fill"></i> Add Account
    </a>
    <a href="AdminListofAccounts.php">
        <i class="ri-team-fill"></i> List of Accounts
    </a>
    <a href="#" onclick="openPersonnelModal()">
        <i class="ri-user-add-fill"></i> Add Personnel/s
    </a>
</div>


      </section>

   </main>
   <div id="addAccountModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAccountModal()">&times;</span>
        <h2>Add Account</h2>
        <form method="POST" action="../../conditions/AdminAddAccount.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="admin">Admin</option>
                <option value="auditor">Auditor</option>
                <option value="supervisor">Supervisor</option>
                <option value="data_analyst">Data Analyst</option>
                <option value="agent">Agent</option>
            </select>
            <button type="submit" name="add_account">Add Account</button>
        </form>
    </div>
</div>

<div id="addPersonModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePersonnelModal()">&times;</span>
        <h2>Add Personnel</h2>
        <form method="POST" action="">
            <select name="role_type" id="role_type" onchange="toggleFields()" required>
                <option value="" disabled selected>Select Type</option>
                <option value="agent">Agent</option>
                <option value="auditor">Auditor</option>
                <option value="supervisor">Supervisor</option>
                <option value="data_analyst">Data Analyst</option>
            </select>

            <!-- Agent Fields -->
            <div id="agentFields" style="display:none; margin-top:15px;">
                <input type="text" name="agent_firstname" placeholder="First Name">
                <input type="text" name="agent_lastname" placeholder="Last Name">
                <input type="date" name="agent_birthday">
                <input type="email" name="agent_email" placeholder="Email">
                <select name="agent_team">
                    <option value="" disabled selected>Select Team</option>
                    <option value="Team Alpha">Team Alpha</option>
                    <option value="Team Bravo">Team Bravo</option>
                    <option value="Team Charlie">Team Charlie</option>
                </select>
            </div>

            <!-- Auditor Fields -->
            <div id="auditorFields" style="display:none; margin-top:15px;">
                <input type="text" name="auditor_firstname" placeholder="First Name">
                <input type="text" name="auditor_lastname" placeholder="Last Name">
                <input type="date" name="auditor_birthday">
                <input type="email" name="auditor_email" placeholder="Email">
                <select name="auditor_department">
                    <option value="" disabled selected>Select Department</option>
                    <option value="QA Department">QA Department</option>
                    <option value="Operations">Operations</option>
                    <option value="IT Support">IT Support</option>
                </select>
            </div>

            <!-- Supervisor Fields -->
            <div id="supervisorFields" style="display:none; margin-top:15px;">
                <input type="text" name="supervisor_firstname" placeholder="First Name">
                <input type="text" name="supervisor_lastname" placeholder="Last Name">
                <input type="date" name="supervisor_birthday">
                <input type="email" name="supervisor_email" placeholder="Email">
                <select name="supervisor_team">
                    <option value="" disabled selected>Select Team</option>
                    <option value="Team Alpha">Team Alpha</option>
                    <option value="Team Bravo">Team Bravo</option>
                    <option value="Team Charlie">Team Charlie</option>
                </select>
            </div>

            <!-- Data Analyst Fields -->
            <div id="dataAnalystFields" style="display:none; margin-top:15px;">
                <input type="text" name="data_analyst_firstname" placeholder="First Name">
                <input type="text" name="data_analyst_lastname" placeholder="Last Name">
                <input type="date" name="data_analyst_birthday">
                <input type="email" name="data_analyst_email" placeholder="Email">
                <select name="data_analyst_department">
                    <option value="" disabled selected>Select Department</option>
                    <option value="QA Department">QA Department</option>
                    <option value="Operations">Operations</option>
                    <option value="IT Support">IT Support</option>
                </select>
            </div>

            <button type="submit" name="add_person">Add</button>
        </form>
    </div>
</div>


<!-- Modal Toggle Script -->
<script>
// ---------- Toggle Fields Based on Role ----------
function toggleFields() {
    const role = document.getElementById("role_type").value;
    const sections = ["agent", "auditor", "supervisor", "dataAnalyst"];
    
    sections.forEach(sec => {
        const div = document.getElementById(sec + "Fields");
        const inputs = div.querySelectorAll("input, select");
        if (role === sec || (sec === "dataAnalyst" && role === "data_analyst")) {
            div.style.display = "block";
            inputs.forEach(i => i.required = true);
        } else {
            div.style.display = "none";
            inputs.forEach(i => i.required = false);
        }
    });
}

// ---------- Open/Close Personnel Modal ----------
function openPersonnelModal() {
    document.getElementById("addPersonModal").style.display = "flex";
}
function closePersonnelModal() {
    document.getElementById("addPersonModal").style.display = "none";
}

// ---------- Optional: Open/Close Account Modal ----------
function openAccountModal() {
    document.getElementById("addAccountModal").style.display = "flex";
}
function closeAccountModal() {
    document.getElementById("addAccountModal").style.display = "none";
}

// ---------- Close Modal if Clicked Outside ----------
window.onclick = function(event) {
    const personnelModal = document.getElementById("addPersonModal");
    const accountModal = document.getElementById("addAccountModal");
    if(event.target === personnelModal) personnelModal.style.display = "none";
    if(event.target === accountModal) accountModal.style.display = "none";
}
</script>


</script>


</script>

   <!--=============== MAIN JS ===============-->
   <script src="../../assets/js/main.js"></script>

   <!-- Slideshow JS -->
   <script>
      let slideIndex = 0;
      let autoSlideTimeout;

      function showSlides() {
         let slides = document.getElementsByClassName("slide");
         let dots = document.getElementsByClassName("dot");

         for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
         }
         slideIndex++;
         if (slideIndex > slides.length) {slideIndex = 1}

         for (let i = 0; i < dots.length; i++) {
            dots[i].classList.remove("active-dot");
         }

         slides[slideIndex-1].style.display = "block";  
         dots[slideIndex-1].classList.add("active-dot");

         autoSlideTimeout = setTimeout(showSlides, 5000); // Auto slide
      }

      function currentSlide(n) {
         clearTimeout(autoSlideTimeout);
         slideIndex = n - 1;
         showSlides();
      }

      // Start slideshow
      showSlides();
   </script>
</body>
</html>

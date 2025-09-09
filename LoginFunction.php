<?php
include('database/dbconnection.php');
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $selected_role = trim($_POST['role']); // capture role input

    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($db_password, $role);
        $stmt->fetch();

        // For this setup, we assume plain-text passwords for now
        if ($password === $db_password && strtolower($selected_role) === strtolower($role)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

if ($role === 'admin') {
    header("Location: pages/admin/AdminDashboard.php");
} elseif ($role === 'auditor') {
    header("Location: pages/auditor/AuditorDashboard.php");
} elseif ($role === 'supervisor') {
    header("Location: pages/supervisor/SupervisorDashboard.php");
} elseif ($role === 'data_analyst') {
    header("Location: pages/data_analyst/DataAnalystDashboard.php");
} else {
    // optional fallback
    header("Location: dashboard.php");


                $error = "Unauthorized role.";
            }
            exit();
        } else {
            $error = "Invalid username, password, or role!";
        }
    } else {
        $error = "Invalid username or password!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Nunito Sans', sans-serif;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('assets/img/background.jpg') no-repeat center center/cover;
            filter: blur(2px);
            z-index: 0;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 65px;  
            border-radius: 25px;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.4);
            width: 550px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
        }

        .login-container h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 20px;
        }

        .input-row {
            display: flex;
            gap: 15px;
            margin-bottom: 8px;
        }

        .input-row input, .input-row select {
            flex: 2;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container select {
            width: 100%;
            padding: 15px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .login-container button {
            width: 100%;
            padding: 15px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #002244;
        }

        .show-password {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 8px 0 12px 2px; /* aligns with inputs */
            font-size: 14px;
            color: #333;
        }

        .show-password input {
            transform: scale(1.1);
            cursor: pointer;
            margin: 0;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="background"></div> 

<div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="input-row">
            <input type="text" name="username" placeholder="Username" required>
            <select name="role" required>
                <option value="" disabled selected>Choose role</option>
                <option value="admin">Administrator</option>
                <option value="auditor">Auditor</option>
                <option value="supervisor">Supervisor</option>
                <option value="data_analyst">Data Analyst</option>
            </select>
        </div>
        <input type="password" id="password" name="password" placeholder="Password" required>
        
        <label class="show-password">
            <input type="checkbox" id="showPassword" onclick="togglePassword()"> 
            <span>Show Password</span>
        </label>

        <button type="submit">Login</button>
    </form>
</div>

<script>
function togglePassword() {
    var pass = document.getElementById("password");
    pass.type = (pass.type === "password") ? "text" : "password";
}
</script>

</body>
</html>

<?php 
include('../../database/dbconnection.php'); 

// Auditors list
$auditors_query = "SELECT id, auditor_firstname, auditor_lasttname FROM auditors2";
$auditors_result = mysqli_query($conn, $auditors_query);

// Agents list
$agents_query = "SELECT id, agent_firsttname, agent_lastname FROM agents";
$agents_result = mysqli_query($conn, $agents_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agent Audit Sheet</title>
    <!-- Remix Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" />
    <!-- Custom Styles -->
    <link rel="stylesheet" href="../../assets/css/styles.css" />

    <style>
        .top-notification {
            position: fixed;
            top: 0; /* stick at very top of the page */
            left: 0;
            width: 100%;
            background: #4CAF50; /* success green */
            color: #fff;
            text-align: center;
            padding: 12px;
            font-weight: bold;
            font-size: 16px;
            z-index: 9999;
            display: none;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .info-field select {
            width: 100%;
            padding: 0.6rem;
            border: 1.5px solid #ccc;
            border-radius: 0.8rem;
            font-size: 1rem;
            background-color: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml;charset=US-ASCII,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='gray'><polygon points='0,0 10,0 5,5'/></svg>");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 0.8rem;
        }

        body {
            font-family: 'Nunito Sans', sans-serif;
            background-color: #f4f6fa;
            margin: 0;
            padding: 0;
        }

        .main.container {
            padding: 2rem;
            max-width: 1300px;
            margin: 80px auto;
        }

        h1 {
            text-align: left;
            font-size: 2rem;
            margin-bottom: 2rem;
            font-weight: 700;
        }

        .info-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-bottom: 1.5rem;
            background: #fff;
            padding: 1rem;
            border-radius: 0.8rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            width: 120%;
        }

        .info-field {
            flex: 1;
            min-width: 250px;
        }

        .info-field label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            color: #333;
        }

        .info-field input, .info-field textarea {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 0.8rem;
            font-size: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border-radius: 0.8rem;
            overflow: hidden;
        }

        th, td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #1a237e;
            color: #fff;
            font-weight: 600;
        }

        td:first-child {
            text-align: left;
            font-weight: 600;
            color: #1a237e;
        }

        input[type="radio"] {
            transform: scale(1.2);
            cursor: pointer;
        }

        .submit-btn {
            margin-top: 1.5rem;
            background-color: #1a237e;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0d1b5e;
        }

        .success, .error {
            margin-top: 1rem;
            font-weight: 600;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
   <div id="notification" class="top-notification"></div>

<!--=============== HEADER ===============-->
<header class="header" id="header">
   
   <div class="header__container">
      <button class="header__toggle" id="header-toggle">
         <i class="ri-menu-line"></i>
      </button>
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
                    <img src="../../assets/img/perfil.png" alt="image" />
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
                        <a href="AuditorDashboard.php" class="sidebar__link">
                            <i class="ri-dashboard-horizontal-fill"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="AuditorAuditForm.php" class="sidebar__link active-link">
                            <i class="ri-survey-fill"></i>
                            <span>Unify Audit System (UAS)</span>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="sidebar__title">TOOLS</h3>
                    <div class="sidebar__list">
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

    <!-- MAIN -->
    <main class="main container" style="margin-left: 350px;" id="main">
        <h1>Agent Audit Sheet</h1>

        <form method="POST">
            <div class="info-bar">
                <!-- Reviewer Dropdown -->
                <div class="info-field">
                    <label>Reviewer:</label>
                    <select name="reviewer_name" required>
                        <option value=""> Select Reviewer</option>
                        <?php while ($row = mysqli_fetch_assoc($auditors_result)) : 
                            $fullname = $row['auditor_firstname'] . " " . $row['auditor_lasttname']; ?>
                            <option value="<?php echo htmlspecialchars($fullname); ?>"><?php echo htmlspecialchars($fullname); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Agent Dropdown -->
                <div class="info-field">
                    <label>Agent's Name:</label>
                    <select name="agent_name" required>
                        <option value=""> Select Agent</option>
                        <?php while ($row = mysqli_fetch_assoc($agents_result)) : 
                            $fullname = $row['agent_firsttname'] . " " . $row['agent_lastname']; ?>
                            <option value="<?php echo htmlspecialchars($fullname); ?>"><?php echo htmlspecialchars($fullname); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="info-field">
                    <label>Status:</label>
                    <input type="text" name="status" list="status-options" required />
                    <datalist id="status-options">
                        <option value="Regular" />
                        <option value="Probationary" />
                        <option value="Trainee" />
                        <option value="Others" />
                    </datalist>
                </div>

                <div class="info-field">
                    <label>Date:</label>
                    <input type="date" name="date" id="date" required />
                </div>

                <div class="info-field">
                    <label>Week:</label>
                    <input type="text" name="week" id="week" required />
                </div>

                <div class="info-field">
                    <label>Time:</label>
                    <input type="time" name="time" required />
                </div>

                <div class="info-field">
                    <label>Caller's Name:</label>
                    <input type="text" name="caller_name" required />
                </div>

                <div class="info-field">
                    <label>Duration:</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="number" name="duration_hours" min="0" max="23" placeholder="Hour/s" required />
                        <input type="number" name="duration_minutes" min="0" max="59" placeholder="Minute/s" required />
                        <input type="number" name="duration_seconds" min="0" max="59" placeholder="Second/s" required />
                    </div>
                </div>

                <div class="info-field">
                    <label>MDN:</label>
                    <input type="text" name="mdn" required />
                </div>

                <div class="info-field">
                    <label>Account Number:</label>
                    <input type="text" name="account_number" required />
                </div>
            </div>

            <div style="overflow-x: auto; margin-left: 1px; width: 120%;">
                <table>
                    <thead>
                        <tr>
                            <th>Audit Criteria</th>
                            <th>Yes</th>
                            <th>No</th>
                            <th>N/A</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $questions = [
                            "Adheres to schedule and login time",
                            "Follows proper call handling procedures",
                            "Demonstrates product knowledge",
                            "Maintains professional tone",
                            "Uses appropriate language",
                            "Accurate documentation",
                            "Customer empathy and support",
                            "Problem resolution effectiveness",
                            "Compliance with company policy",
                            "Follows QA guidelines"
                        ];
                        foreach ($questions as $index => $q) :
                            $num = $index + 1; ?>
                            <tr>
                                <td><?php echo htmlspecialchars($q); ?></td>
                                <td><input type="radio" name="q<?php echo $num; ?>" value="Yes" required /></td>
                                <td><input type="radio" name="q<?php echo $num; ?>" value="No" /></td>
                                <td><input type="radio" name="q<?php echo $num; ?>" value="N/A" /></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="info-bar" style="margin-top: 2rem;">
                <div class="info-field" style="flex: 1 1 100%;">
                    <label>Comments:</label>
                    <textarea name="comment" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" name="submit" class="submit-btn">Submit Audit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $hours   = (int)$_POST['duration_hours'];
            $minutes = min((int)$_POST['duration_minutes'], 59);
            $seconds = min((int)$_POST['duration_seconds'], 59);
            $duration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

            $reviewer = $_POST['reviewer_name'];
            $agent = $_POST['agent_name'];
            $status = $_POST['status'];
            $date = $_POST['date'];
            $week = $_POST['week'];
            $time = $_POST['time'];
            $caller = $_POST['caller_name'];
            $queue = $_POST['queue'];
            $mdn = $_POST['mdn'];
            $account = $_POST['account_number'];
            $comment = $_POST['comment'];

            // Collect responses
            $responses = [];
            for ($i = 1; $i <= 10; $i++) {
                $responses[] = $_POST["q$i"] ?? 'N/A';
            }

            $stmt = $conn->prepare("
                INSERT INTO data_reports 
                (reviewer_name, agent_name, status, date, week, time, caller_name, duration, queue, mdn, account_number, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, comment)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
            ");

            $stmt->bind_param(
                "ssssssssssssssssssssss",
                $reviewer, $agent, $status, $date, $week, $time, $caller, $duration, $queue, $mdn, $account,
                $responses[0], $responses[1], $responses[2], $responses[3], $responses[4], $responses[5],
                $responses[6], $responses[7], $responses[8], $responses[9], $comment
            );

            if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const n = document.getElementById('notification');
                        n.textContent = 'Audit submitted successfully!';
                        n.style.background = '#4CAF50';
                        n.style.display = 'block';
                        setTimeout(() => { n.style.display = 'none'; }, 4000);
                    });
                </script>";
            } else {
                $error = addslashes($stmt->error);
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const n = document.getElementById('notification');
                        n.textContent = 'Error: {$error}';
                        n.style.background = '#f44336';
                        n.style.display = 'block';
                        setTimeout(() => { n.style.display = 'none'; }, 5000);
                    });
                </script>";
            }
            $stmt->close();
        }
        ?>
    </main>

    <script>
        document.getElementById("date").addEventListener("change", function() {
            const inputDate = new Date(this.value);

            if (!isNaN(inputDate)) {
                // Get the ISO week number
                const target = new Date(inputDate.valueOf());
                const dayNr = (inputDate.getDay() + 6) % 7; // Make Monday = 0
                target.setDate(target.getDate() - dayNr + 3);
                const firstThursday = target.valueOf();
                target.setMonth(0, 1);
                if (target.getDay() !== 4) {
                    target.setMonth(0, 1 + ((4 - target.getDay()) + 7) % 7);
                }
                const weekNumber = 1 + Math.ceil((firstThursday - target) / 604800000);

                document.getElementById("week").value = "Week " + weekNumber;
            }
        });

        
    </script>

    <script src="../../assets/js/main.js"></script>
</body>
</html>

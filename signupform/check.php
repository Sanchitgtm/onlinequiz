<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'session');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <style>
        /* Animated Gradient Background */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(180deg, #0f0c29, #302b63, #24243e);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            color: white;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphic Container */
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 600px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #00FFCB;
            text-transform: uppercase;
        }

        /* Styled Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        th {
            background: rgba(0, 255, 203, 0.3);
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Neon Button */
        .logout-btn {
            display: inline-block;
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            transition: 0.3s ease-in-out;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .logout-btn:hover {
            background: linear-gradient(90deg, #ff4b2b, #ff416c);
            transform: scale(1.05);
            box-shadow: 0px 0px 20px rgba(255, 75, 43, 0.8);
        }

    </style>
</head>
<body>

    <!-- Quiz Results -->
    <div class="container">
        <h2>Quiz Results</h2>
        <table>
            <tr>
                <th colspan="2">Results</th>
            </tr>
            <tr>
                <td>Questions Attempted</td>
                <?php
                $resultans = 0;
                if (isset($_POST['submit'])) {
                    if (!empty($_POST['quiz'])) {
                        $count = count($_POST['quiz']);
                ?>
                <td><?php echo "Out of 10, you selected " . $count . " options"; ?></td>
            </tr>
            <?php
                        $selected = $_POST['quiz'];
                        $sql = "SELECT ans_id FROM question";
                        $ansresult = mysqli_query($conn, $sql);
                        $i = 1;
                        while ($rows = mysqli_fetch_array($ansresult)) {
                            if (isset($selected[$i]) && $rows['ans_id'] == $selected[$i]) {
                                $resultans++;
                            }
                            $i++;
                        }
            ?>
            <tr>
                <td>Your Total Score</td>
                <td><?php echo "Your score is " . $resultans . "."; ?></td>
            </tr>
            <?php
                    } else {
                        echo "<tr><td colspan='2' style='color: red;'>Please select at least one option.</td></tr>";
                    }
                }
            ?>
        </table>
        
        <?php
        $name = $_SESSION['username'];
        $finalresult = "INSERT INTO users (username, totalques, answerscorrect) VALUES ('$name', '10', '$resultans')";
        mysqli_query($conn, $finalresult);
        ?>

        <a href="logout.php" class="logout-btn">LOGOUT</a>
    </div>

    <!-- Users Table -->
    <div class="container">
        <h2>Users & Scores</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Score</th>
            </tr>
            <?php
            $sql = "SELECT username, answerscorrect FROM users ORDER BY answerscorrect DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . ($row['username']) . "</td><td>" . $row['answerscorrect'] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No scores available</td></tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>

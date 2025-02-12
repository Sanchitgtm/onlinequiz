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
    <title>Quiz Page</title>
    <style>
        /* Animated Background */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(180deg, #0f0c29, #302b63, #24243e);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Header */
        header {
            text-align: center;
            margin-top: 20px;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            color: #FFD700;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
        }

        /* Logout Button */
        .logout-link {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .logout-link a {
            text-decoration: none;
            color: #FF4B2B;
            font-weight: bold;
            text-transform: uppercase;
            border: 2px solid #FF4B2B;
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .logout-link a:hover {
            background: #FF4B2B;
            color: white;
            box-shadow: 0px 0px 15px rgba(255, 75, 43, 0.8);
        }

        /* Glassmorphic Quiz Box */
        .quiz-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 90%;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 30px;
        }

        h3 {
            color: #00FFCB;
            font-size: 22px;
            margin-bottom: 20px;
        }

        h4 {
            color: white;
            font-size: 20px;
            margin-top: 15px;
            background-color:#00a1ff42;
        }

        /* Quiz Options */
        .quiz-options {
            text-align: left;
            margin: 10px 0;
        }

        .quiz-options label {
            display: block;
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .quiz-options input {
            margin-right: 10px;
        }

        .quiz-options label:hover {
            background: rgba(0, 255, 203, 0.2);
        }

        /* Submit Button */
        .submit-btn {
            min-width: 300px;
            min-height: 60px;
            display: inline-flex;
            font-size: 22px;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 1.3px;
            font-weight: 700;
            color: #313133;
            background: linear-gradient(90deg, rgba(129,230,217,1) 0%, rgba(79,209,197,1) 100%);
            border: none;
            border-radius: 50px;
            box-shadow: 6px 6px 18px rgba(79,209,197,.64);
            transition: 0.3s ease-in-out;
            cursor: pointer;
            outline: none;
            padding: 10px;
            margin-top: 20px;
            position: relative;
        }

        .submit-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0px 0px 20px rgba(79,209,197,0.8);
        }

        /* Responsive */
        @media (max-width: 600px) {
            .quiz-container {
                width: 95%;
            }
        }
    </style>
</head>
<body>

    <header>
        Welcome, <?php echo $_SESSION['username']; ?>
    </header>

    <div class="logout-link">
        <a href="logout.php">Logout</a>
    </div>

    <div class="quiz-container">
        <h3>Welcome <?php echo $_SESSION['username']; ?>! Please select one option per question. Best of luck! 🎉</h3>
        <form action="check.php" method="POST">

            <?php
            for ($i = 1; $i <= 10; $i++) {
                $sql = "SELECT * FROM question WHERE qid=$i";
                $query = mysqli_query($conn, $sql);

                while ($rows = mysqli_fetch_array($query)) {
            ?>
                    <h4><?php echo $rows['questions']; ?></h4>
                    <div class="quiz-options">
                        <?php
                        $sql2 = "SELECT * FROM answer WHERE ans_id=$i";
                        $query2 = mysqli_query($conn, $sql2);

                        while ($rows2 = mysqli_fetch_array($query2)) {
                        ?>
                            <label>
                                <input type="radio" name="quiz[<?php echo $rows2['ans_id']; ?>]" value="<?php echo $rows2['aid']; ?>">
                                <?php echo $rows2['answers']; ?>
                            </label>
                        <?php
                        }
                        ?>
                    </div>
            <?php
                }
            }
            ?>

            <input type="submit" value="Submit" name="submit" class="submit-btn">
        </form>
    </div>

</body>
</html>

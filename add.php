<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Add Streak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
        }

        .button:hover {
            background-color: #3e8e41
        }

        .button:active {
            background-color: #3e8e41;
            transform: translateY(4px);
        }

        #name, #streak {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #af4c4c;
            border: none;
            border-radius: 15px;
        }

        .back-button:hover {
            background-color: #7d3535
        }

        .back-button:active {
            background-color: #7d3535;
            transform: translateY(4px);
        }

        #evidence {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        h1 {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Add Streak</h1>
    <form action="add.php" method="post" enctype="multipart/form-data">
        <label for="name"><i class="fas fa-user"></i> Name</label>
        <input type="text" id="name" name="name" required>
        <label for="streak"><i class="fas fa-fire"></i> Streak (Days)</label>
        <input type="number" id="streak" name="streak" min="1" required>
        <label for="evidence"><i class="fas fa-file-image"></i> Evidence</label>
        <input type="file" id="evidence" name="evidence" accept="image/*" required>
        <button type="submit" class="button"><i class="fas fa-paper-plane"></i> Submit</button>
        <a href="index.php" class="back-button"><i class="fas fa-home"></i> Back to Home</a>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $streak = $_POST["streak"];
        $evidence = isset($_POST["evidence"]) ? $_POST["evidence"] : null;
        //$evidence = $_POST["evidence"];
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "leaderboard";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }

        $evidence = isset($_FILES['evidence']['tmp_name']) ? addslashes(file_get_contents($_FILES['evidence']['tmp_name'])) : null;
        //$evidence = addslashes(file_get_contents($_FILES['evidence']['tmp_name']));

        $result = $conn->query("SELECT * FROM scores WHERE name='$name'");

        if ($result->num_rows > 0) {
            $sql = "UPDATE scores SET streak='$streak', evidence='$evidence', date=CURDATE() WHERE name='$name'";
        } else {
            $result = $conn->query("SELECT MAX(uid) AS max_id FROM scores");
            $row = $result->fetch_assoc();
            $new_id = $row['max_id'] + 1;
            
            $sql = "INSERT INTO scores (uid, name, streak, evidence)
            VALUES ('$new_id', '$name', '$streak', '$evidence')";
        }
        
        if ($conn->query($sql) === TRUE) {
            echo "New Record Created Successfully";
            $conn->close();
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
    }
    ?>
</body>
</html>
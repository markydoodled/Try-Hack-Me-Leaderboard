<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Try Hack Me Leaderboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        h1 {
            color: #333;
            text-align: center;
            padding: 20px 0;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
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
            margin-bottom: 20px;
        }

        .button:hover {
            background-color: #3e8e41
        }

        .button:active {
            background-color: #3e8e41;
            transform: translateY(4px);
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 10vh;
        }
    </style>
</head>
<body>
    <h1>Try Hack Me Leaderboard</h1>
    <div class="center-container">
        <p><a href="add.php" class="button"><i class="fas fa-plus"></i> Add Streak</a></p>
    </div>
    <table>
        <tr>
            <th><i class="fas fa-trophy"></i> Rank</th>
            <th><i class="fas fa-user"></i> Name</th>
            <th><i class="fas fa-fire"></i> Streak (Days)</th>
            <th><i class="fas fa-check"></i> Evidence</th>
        </tr>
        <?php
            $conn = mysqli_connect("localhost", "root", "", "leaderboard");
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }

            $date_week_ago = date('Y-m-d', strtotime('-1 week'));

            $sql = "SELECT * FROM scores WHERE date >= '$date_week_ago' ORDER BY streak DESC";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $rank = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $rank . "</td><td>" . $row["name"]. "</td><td>" . $row["streak"]. "</td><td><img src='data:image/jpeg;base64,".base64_encode( $row['evidence'] )."'/></td></tr>";
                    $rank++;
                }
            } else {
                echo "0 Results";
            }
            $conn->close();
        ?>
    </table>
</body>
</html>
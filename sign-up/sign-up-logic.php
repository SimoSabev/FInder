<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Парола
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Връзки
    $conn = new mysqli("sql11.freemysqlhosting.net", "sql11665896", "Mfc5Y2lNTe", "sql11665896"); 
    
   

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Име
    $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUsernameQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Username is already taken. Please choose another one.";
    } else {
        //Данни
        $insertQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ss", $username, $hashedPassword);
        if ($stmt->execute()) {
            readfile("D:/SaitOnline/server/Server/htdocs/log-in/log-in.php"); //Прехвърляне
       
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
    
}
?>
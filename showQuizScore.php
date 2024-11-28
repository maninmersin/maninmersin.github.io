<!DOCTYPE html>
<html>
<body>

<?php
$servername = "localhost";
$username = "euitt_stuart";
$password = "joshua5605";
$dbname = "euitt_quiz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT quizLearnerName, quizLearnerID, quizLessonName, quizScore FROM tblQuizResult";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo "<br> ". $row["quizLearnerName"]. ",". $row["quizLearnerID"].",". $row["quizLessonName"].",".  $row["quizScore"]. "<br>";
     }
} else {
     echo "0 results";
}

$conn->close();
?>  

</body>
</html>
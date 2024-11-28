<!DOCTYPE html>
<html>
<body>

<?php
$con=mysqli_connect('localhost', 'root', 'Admin','euittcom_quiz');
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM tblQuizResult");

echo "<table border='1'>
<tr>
<th>quizLearnerName</th>
<th>quizLearnerID</th>
<th>quizLessonName</th>
<th>Store</th>
<th>Dept</th>
<th>Role</th>
<th>quizScore</th>
<th>quizDate</th>
<th>quizStatus</th>
<th>quizDuration</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['quizLearnerName'] . "</td>";
echo "<td>" . $row['quizLearnerID'] . "</td>";
echo "<td>" . $row['quizLessonName'] . "</td>";
echo "<td>" . $row['Store'] . "</td>";
echo "<td>" . $row['Dept'] . "</td>";
echo "<td>" . $row['Role'] . "</td>";
echo "<td>" . $row['quizScore'] . "</td>";
echo "<td>" . $row['quizDate'] . "</td>";
echo "<td>" . $row['quizStatus'] . "</td>";
echo "<td>" . $row['quizDuration'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>

</body>
</html>
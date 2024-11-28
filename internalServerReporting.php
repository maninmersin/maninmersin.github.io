<?php

session_start();

# InternalServerReporting.php
# Copyright 2000-2008 Adobe Systems Incorporated. All rights reserved.
#
print "<pre>\n";

#

// specify the mysql connection information
// Apache and mySQL in same host, we just apply 'localhost' in the host ip is fine
$link = mysql_connect('localhost', 'euittcom_stuart', 'Joshua5605');

foreach ($_POST as $k => $v)
  {
    if ($k == "CompanyName")
      {
        $CompanyName = $v;
      }
    if ($k == "DepartmentName")
      {
        $DepartmentName = $v;
      }
    if ($k == "CourseName")
      {
        $CourseName = $v;
      }
    if ($k == "Filename")
      {
        $Filename = str_replace(array(
            ','
        ), '_', $v);
      }
    if ($k == "Filedata")
      {
        if (get_magic_quotes_gpc())
            $Filedata = stripslashes($v);
        else
            $Filedata = $v;
      }
  }

$ResultFolder = "./" . "CaptivateResults";
mkdir($ResultFolder);
$CompanyFolder = $ResultFolder . "//" . $CompanyName;
mkdir($CompanyFolder);
$DepartmentFolder = $CompanyFolder . "//" . $DepartmentName;
mkdir($DepartmentFolder);
$CourseFolder = $DepartmentFolder . "//" . $CourseName;
mkdir($CourseFolder);
$FilePath = $CourseFolder . "//" . $Filename;
$Handle   = fopen($FilePath, 'w');
fwrite($Handle, $Filedata);
fclose($Handle);

// Split data from xml

$sample         = simplexml_load_file($FilePath);
$LearnerID      = $sample->LearnerID['value'];
$LearnerName    = $sample->LearnerName['value'];
$LessonName     = $sample->LessonName['value'];
$QuizAttempts   = $sample->QuizAttempts['value'];
$TotalQuestions = $sample->TotalQuestions['value'];
$Score          = $sample->Result->CoreData->Score['value'];
$Name           = $sample->Variables->name['value'];
$Date           = $sample->Result->InteractionData->Interactions->Date['value'];
$Status         = $sample->Result->CoreData->Status['value'];
$QuizDuration   = $sample->Result->CoreData->SessionTime['value'];
$RawScore       = $sample->Result->CoreData->RawScore['value'];
$MaxScore       = $sample->Result->CoreData->MaxScore['value'];
$MinScore       = $sample->Result->CoreData->MinScore['value'];

// write the data to file for backup
$content .= $CompanyName . "\n";
$content .= ",\n";
$content .= $DepartmentName . "\n";
$content .= ",\n";
$content .= $CourseName . "\n";
$content .= ",\n";
$content .= $LearnerID . "\n";
$content .= ",\n";
$content .= $LessonName . "\n";
$content .= ",\n";
$content .= $QuizAttempts . "\n";
$content .= ",\n";
$content .= $TotalQuestions . "\n";
$content .= ",\n";
$content .= $Name . "\n";
$content .= ",\n";
$content .= $Score . "\n";
$content .= ",\n";
$content .= $Date . "\n";
$content .= ",\n";
$content .= $Status . "\n";
$content .= ",\n";
$content .= $QuizDuration . "\n";
$content .= ",\n";
$content .= $RawScore . "\n";
$content .= ",\n";
$content .= $MaxScore . "\n";
$content .= ",\n";
$content .= $MinScore . "\n";

$Handle1 = fopen($FilePath . ".txt", 'w');
fwrite($Handle1, $content);
fclose($Handle1);


// connect to a8818410_quiz

mysql_select_db('euittcom_quiz');

// insert the core data into tblQuizResult
$sqlQuizResult = "INSERT INTO tblQuizResult (quizCompanyName, quizDepartmentName, quizCourseName, quizLearnerName, quizLearnerID, quizLessonName, quizAttempts, quizTotalQuestions, quizName, quizScore, quizDate, quizStatus,quizDuration, quizRawScore, quizMaxScore, quizMinScore) 
VALUES ('$CompanyName','$DepartmentName','$CourseName','$LearnerName','$LearnerID','$LessonName','$QuizAttempts','$TotalQuestions','$Name','$Score','$Date','$Status','$QuizDuration','$RawScore','$MaxScore','$MinScore')";

if (!mysql_query($sqlQuizResult, $link))
  {
    die('Could not insert data into tblcore.  Died with this error: ' . mysql_error());
  }
else
  {
    if ($debugMode == 1)
      {
        print('tblQuizResult values were written.<br />');
      }
  }
// close db server connection
mysql_close($link);



print "</pre>\n";
?>

<?php
require("classes/security.php");
require("classes/dbutils.php");
require("classes/levelsecurity.php");
require("classes/question.php");

$pageTitle = "Welcome to dental pathology game";
require("header.php");

$drupalUserID = $_SESSION["drupalUserID"]; //Sets session data
?>

<script language="javascript" type="text/javascript">
    var score = 0;
    $(document).ready(function () { //When page is loaded
        function getWinData(attemptID, userID, levelID) { //send IDs for attempt, user, and level to getWinData
            var scoreData = {}; /*set score data */
            scoreData.userID = userID; //Sets user ID
            scoreData.levelID = levelID; //Sets level ID
            scoreData.attemptID = attemptID; //Sets attempt ID
			
            $.post("rest/getscore.php", scoreData).done(function (data) {
                var jsonData = JSON.parse(data); //Parse the data from json form
                var numberCorrect = 0; //Number of answers correct from scoreData
                var questionsCompleted = jsonData.questionComplete.length; //Sets variable to number of questions completed from the data converted from Json.
                for (i = 0; i < parseInt(jsonData.score.length); i++) { //iterate through length of score
                    if (parseInt(jsonData.score[i].scoreRecieved) > 0) { //if score is greater than zero
                        numberCorrect++; //increment number correct
                        score += +parseInt(jsonData.score[i].scoreRecieved); //add score
                    }
                }
                $('#scoreDisplay').html("<h1>Final Score: " + score + "</h1>"); //display score
                $('#scoreDisplay').trigger('pagecreate'); //the score is displayed when the page is initialized
            });
        }
        getWinData('<?php echo $_SESSION["gameAttemptID"]; ?>', '<?php echo $drupalUserID; ?>', 4);
    });
</script>
<h1 id="scoreDisplay"> Congratulations you have won! </h1>
<div id="scoreDisplay"></div>
<!-- Please show score here -->
<?php
require("footer.php");
?>

<?php
/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/21/17
 * Time: 1:34 PM
 */
include '../common/Database.php';
$result = fetchQuestionData();
$ac = isset($_GET["ac"])?$_GET["ac"]:"";
?>
    <html>
    <head>
        <?php
        include "../assets/requiredFiles.php";
        ?>
        <script type="text/javascript">
            $(function(){
                $("#questions").DataTable();
            })
        </script>
    </head>
    <body>
    <?php
    if($ac =="" ){
        ?>
        <table id="questions" class="mdl-data-table dataTable">
            <thead>
            <tr>
                <th>Question Id</th>
                <th>Topic Id</th>
                <th>Question</th>
                <th>Question Augment</th>
                <th>Hint</th>
                <th>Difficulty</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$row['question_id']."</td>";
                echo "<td>".$row['topic_id']."</td>";
                echo "<td>".$row['question_val']."</td>";
                echo "<td>".$row['question_augment']."</td>";
                echo "<td>".$row['hint']."</td>";
                echo "<td>".$row['difficulty']."</td>";
                echo "<td><a href='questions.php?ac=edit&qId=" .$row['question_id']."'>Edit</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
    }
    else if ($ac == "edit"){
        $qId = $_GET["qId"];
        $result = getValueByQuestionId($qId);
        while ($row = mysqli_fetch_assoc($result)){
            ?>
            <form action="updateForm.php" method="post">
                <input type="hidden" id="question_id" name="question_id" value="<?php echo $row['question_id']?>"/>
                <label for="topic_id">Topic Id</label>
                <input type="text" id="topic_id" name="topic_id" value="<?php echo $row['topic_id']?>"/>
                <label for="question_val">Question</label>
                <input type="text" id="question_val" name="question_val" value="<?php echo $row['question_val']?>"/>
                <label for="question_augment">Question Augment</label>
                <input type="text" id="question_augment" name="question_augment" value="<?php echo $row['question_augment']?>"/>
                <label for="hint">Hint</label>
                <input type="text" id="hint" name="hint" value="<?php echo $row['hint']?>"/>
                <label for="difficulty">Difficulty</label>
                <input type="text" id="difficulty" name="difficulty" value="<?php echo $row['difficulty']?>"/>
                <input type="hidden" name="formType" value="questions"/>
                <input type="submit" value="Update"/>
            </form>
            <?php
        }
    }
    ?>
    </body>
    </html>
<?php
function fetchQuestionData(){
    $questionQuery = "select *from questions";
    $database = new Database();
    $result = $database->selectQuery($questionQuery);
    return $result;
}

function getValueByQuestionId($qId){
    $questionSpecificQuery = "select *from questions where question_id=$qId";
    $database = new Database();
    $result = $database->selectQuery($questionSpecificQuery);
    return $result;
}

?>
<?php
/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/21/17
 * Time: 1:34 PM
 */
include '../common/Database.php';
$ac = isset($_GET["ac"])?$_GET["ac"]:"";
?>
<html>
<head>
    <?php
    include "../assets/requiredFiles.php";
    ?>
    <script type="text/javascript">
        $(function(){
            $("#answers").DataTable();
        })
    </script>
</head>
<body>
<?php
if($ac =="" ){
$result = fetchAnswersData();
?>
<table id="answers">
    <thead>
    <tr>
        <th>Answer Id</th>
        <th>Question Id</th>
        <th>Answer</th>
        <th>Is Correct</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row['answer_id']."</td>";
        echo "<td>".$row['question_id']."</td>";
        echo "<td>".$row['answer_val']."</td>";
        echo "<td>".$row['is_correct']."</td>";
        echo "<td><a href='answers.php?ac=edit&aId=" .$row['answer_id']."'>Edit</a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
    <?php
}
else if ($ac == "edit"){
    $aId = $_GET["aId"];
    $result = getValueByAnswerId($aId);
    while ($row = mysqli_fetch_assoc($result)){
        ?>
        <form action="updateForm.php" method="post">
            <input type="hidden" id="answer_id" name="answer_id" value="<?php echo $row['answer_id']?>"/>

            <label for="question_id">Question Id</label>
            <input type="text" id="question_id" name="question_id" value="<?php echo $row['question_id']?>"/>

            <label for="answer_val">Answer</label>
            <input type="text" id="answer_val" name="answer_val" value="<?php echo $row['answer_val']?>"/>

            <label for="is_correct">Is Correct</label>
            <input type="checkbox" name="is_correct" id="is_correct" <?php echo $row['is_correct'] == 1?'checked':'' ?>/>

            <input type="hidden" name="formType" value="answers"/>
            <input type="submit" value="Update"/>
        </form>
        <?php
    }
}
?>
</body>
</html>

<?php
function fetchAnswersData(){
    $questionQuery = "select *from answers";
    $database = new Database();
    $result = $database->selectQuery($questionQuery);
    return $result;
}

function getValueByAnswerId($aId){
    $answerSpecificQuery = "select *from answers where answer_id=$aId";
    $database = new Database();
    $result = $database->selectQuery($answerSpecificQuery);
    return $result;
}

?>
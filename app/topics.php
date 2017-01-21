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
                $("#topics").DataTable();
            })
        </script>
    </head>
    <body>
    <?php
    if($ac =="" ){
        $result = fetchTopicsData();
        ?>
        <table id="topics">
            <thead>
            <tr>
                <th>Topic Id</th>
                <th>Topic</th>
                <th>Super Topic</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$row['topic_id']."</td>";
                echo "<td>".$row['topic_val']."</td>";
                echo "<td>".$row['super_topic_val']."</td>";
                echo "<td>".$row['description']."</td>";
                echo "<td><a href='topics.php?ac=edit&tId=" .$row['topic_id']."'>Edit</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
    }
    else if ($ac == "edit"){
        $tId = $_GET["tId"];
        $result = getValueByTopicId($tId);
        while ($row = mysqli_fetch_assoc($result)){
            ?>
            <form action="updateForm.php" method="post">
                <input type="hidden" id="topic_id" name="topic_id" value="<?php echo $row['topic_id']?>"/>

                <label for="topic_val">Topic</label>
                <input type="text" id="topic_val" name="topic_val" value="<?php echo $row['topic_val']?>"/>

                <label for="super_topic_val">Super Topic</label>
                <input type="text" id="super_topic_val" name="super_topic_val" value="<?php echo $row['super_topic_val']?>"/>

                <label for="description">Description</label>
                <input type="text" id="description" name="description" value="<?php echo $row['description']?>"/>

                <input type="hidden" name="formType" value="topics"/>
                <input type="submit" value="Update"/>
            </form>
            <?php
        }
    }
    ?>
    </body>
    </html>

<?php
function fetchTopicsData(){
    $topicQuery = "select *from topics";
    $database = new Database();
    $result = $database->selectQuery($topicQuery);
    return $result;
}

function getValueByTopicId($tId){
    $topicSpecificQuery = "select *from topics where topic_id=$tId";
    $database = new Database();
    $result = $database->selectQuery($topicSpecificQuery);
    return $result;
}

?>
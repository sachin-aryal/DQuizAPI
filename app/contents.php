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
            $("#contents").DataTable();
        })
    </script>
</head>
<body>
<?php
if($ac =="" ){
$result = fetchContentsData();
?>
<table id="contents">
    <thead>
    <tr>
        <th>Id</th>
        <th>Content Id</th>
        <th>Topic Id</th>
        <th>Slide No</th>
        <th>Content Type</th>
        <th>Content Description</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['content_id']."</td>";
        echo "<td>".$row['topic_id']."</td>";
        echo "<td>".$row['slide_no']."</td>";
        echo "<td>".$row['content_type']."</td>";
        echo "<td>".$row['content_desc']."</td>";
        echo "<td><a href='contents.php?ac=edit&cId=" .$row['id']."'>Edit</a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
    <?php
}
else if ($ac == "edit"){
    $cId = $_GET["cId"];
    $result = getValueByContentId($cId);
    while ($row = mysqli_fetch_assoc($result)){
        ?>
        <form action="updateForm.php" method="post">
            <input type="hidden" id="cId" name="cId" value="<?php echo $row['id']?>"/>

            <label for="content_id">Content Id</label>
            <input type="text" id="content_id" name="content_id" value="<?php echo $row['content_id']?>"/>

            <label for="topic_id">Topic Id</label>
            <input type="text" id="topic_id" name="topic_id" value="<?php echo $row['topic_id']?>"/>

            <label for="slide_no">Slide No</label>
            <input type="text" id="slide_no" name="slide_no" value="<?php echo $row['slide_no']?>"/>

            <label for="content_type">Content Type</label>
            <input type="text" id="content_type" name="content_type" value="<?php echo $row['content_type']?>"/>

            <label for="content_desc">Content Description</label>
            <input type="text" id="content_desc" name="content_desc" value="<?php echo $row['content_desc']?>"/>

            <input type="hidden" name="formType" value="contents"/>
            <input type="submit" value="Update"/>
        </form>
        <?php
    }
}
?>
</body>
</html>
<?php
function fetchContentsData(){
    $questionQuery = "select *from contents";
    $database = new Database();
    $result = $database->selectQuery($questionQuery);
    return $result;
}

function getValueByContentId($cId){
    $contentSpecificQuery = "select *from contents where id=$cId";
    $database = new Database();
    $result = $database->selectQuery($contentSpecificQuery);
    return $result;
}

?>
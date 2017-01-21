<?php
/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/21/17
 * Time: 1:34 PM
 */
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
<table id="contents">
    <thead>
    <tr>
        <th>Question Id</th>
        <th>Topic Id</th>
        <th>Question</th>
        <th>Question Augment</th>
        <th>Hint</th>
        <th>Difficulty</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/19/17
 * Time: 9:50 AM
 */

?>
<html>
<head>

</head>
<body>
<h2>Excel File Uploader</h2>

<form enctype="multipart/form-data" action="uploader/excel-upload.php" method="post" >

    <label class="form-label span3" for="file">File</label>
    <input type="file" name="file" id="file" required />
    <br><br>
    <input type="submit" value="Submit" />

</form>

<button onclick="window.location='downloader/excel-download.php?w=content'">Sample Content Format</button>
<button onclick="window.location='downloader/excel-download.php?w=question'">Sample Question Format</button>
<button onclick="window.location='downloader/excel-download.php?w=answer'">Sample Answer Format</button>
<button onclick="window.location='downloader/excel-download.php?w=topic'">Sample Topic Format</button>

</body>
</html>

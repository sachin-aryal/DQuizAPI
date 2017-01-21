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
<style>
    button{
        float: right;
    }
</style>
</head>
<body>
<h2>Dquiz File Uploader</h2>

<form enctype="multipart/form-data" action="uploader/excel-upload.php" method="post" >
    <fieldset>
        <legend>Upload Topics</legend>
        <label class="form-label span3" for="file">File</label>
        <input type="file" name="file" id="file" required />
        <input type="hidden" name="fileType" id="fileType" value="topics"/>
        <br><br>
        <input type="submit" value="Submit" />
        <button type="button" onclick="window.location='downloader/excel-download.php?w=topic'">Sample Topic Format</button>
    </fieldset>
</form>

<form enctype="multipart/form-data" action="uploader/excel-upload.php" method="post" >
    <fieldset>
        <legend>Upload Contents</legend>
        <label class="form-label span3" for="file">File</label>
        <input type="file" name="file" id="file" required />
        <input type="hidden" name="fileType" id="fileType" value="contents"/>
        <br><br>
        <input type="submit" value="Submit" />
        <button type="button" onclick="window.location='downloader/excel-download.php?w=content'">Sample Content Format</button>
    </fieldset>
</form>


<form enctype="multipart/form-data" action="uploader/excel-upload.php" method="post" >
    <fieldset>
        <legend>Upload Questions</legend>
        <label class="form-label span3" for="file">File</label>
        <input type="file" name="file" id="file" required />
        <input type="hidden" name="fileType" id="fileType" value="questions"/>
        <br><br>
        <input type="submit" value="Submit" />
        <button type="button" onclick="window.location='downloader/excel-download.php?w=question'">Sample Question Format</button>
    </fieldset>
</form>

<form enctype="multipart/form-data" action="uploader/excel-upload.php" method="post" >
    <fieldset>
        <legend>Upload Answers</legend>
        <label class="form-label span3" for="file">File</label>
        <input type="file" name="file" id="file" required />
        <input type="hidden" name="fileType" id="fileType" value="answers"/>
        <br><br>
        <input type="submit" value="Submit" />
        <button type="button" onclick="window.location='downloader/excel-download.php?w=answer'">Sample Answer Format</button>
    </fieldset>
</form>

</body>
</html>

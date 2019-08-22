<?php
$current_dir = dirname($_SERVER['SCRIPT_FILENAME']);

$lva_name = basename($current_dir);

$error = "";
$message = "";

// Check if the current request is the upload or a normal visit.
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
    $target_dir = $current_dir . "/uploads/";
    $orig_file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $orig_file_name;

    if (file_exists($target_file)) {
	header("HTTP/1.0 400 Bad Request");
	echo "File already exists";
	exit();
    }
    else if($_FILES['fileupload']['error'] === UPLOAD_ERR_INI_SIZE) {
	header("HTTP/1.0 400 Bad Request");
	echo "File too large.";
	exit();
    }
    else {
	if(!is_dir($target_dir)) {
	    mkdir($target_dir);
	}
	
	move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
	echo "success";
	exit();
    }
}
?>
<html>
    <head>
	<title>Upload new file to <?php echo $lva_name ?></title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/bootstrap.min.css">
	<link rel="stylesheet" href="/dropzone.css">
    </head>
    <body>
	<div class="container">
	    <div class="jumbotron">
		<h1>Upload new file to <?php echo $lva_name; ?></h1>
		<p>This page can be used to upload a new file to <?php echo $lva_name; ?>. After review, it is added to the normal directory.</p>
		<a href="./" class="btn btn-large btn-block btn-secondary">Back to file list</a>
		<?php
		if($error != "") {
		    echo "<p color='red'>Error: <strong>$error</strong></p>";
		}
		if($message != "") {
		    echo "<p>$error</p>";
		}
		?>
	    </div>

	    <form action="upload.php"
		  class="dropzone"
		  id="file">
		<div class="fallback">
		    <input name="file" type="file" multiple />
		</div>
	    </form>
	</div>
	<script src="/dropzone.js"></script>
    </body>
</html>

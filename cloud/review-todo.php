<?php
$current_dir = dirname($_SERVER['SCRIPT_FILENAME']);

$program_name = basename($current_dir);

?>
<html>
    <head>
	<title>Review uploads to program <?php echo $program_name; ?></title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/bootstrap.min.css">
    </head>
    <body>
	<div class="container">
	    <div class="jumbotron">
		<h1>Review uploads to program <?php echo $program_name; ?></h1>
		<p>This page lists all upload folders, where there is still work to do. Click on the link next to the entry to open webdav.</p>
		<a href="./" class="btn btn-large btn-block btn-secondary">Back to file list</a>
	    </div>

	    <?php
	    $directories = glob($current_dir . "/*" , GLOB_ONLYDIR);
	    foreach($directories as $dir) {
		$items = 0;
		$uploads_dir = $dir . "/uploads/";
		if(!file_exists($uploads_dir)) {
		    continue;
		}
		$files = scandir($uploads_dir);
		foreach($files as $file) {
		    if($file != "." && $file != "..") {
			$items += 1;
		    }
		}
		$name = basename($dir);
		if($items > 0) {
		    echo "<h2>$name</h2>";
		    echo "<p>There are $items items to review.</p>";
		    echo "<a class='btn btn-secondary' href='webdav://cloud.oeh-tnf.at/LVAs/$name/uploads'>Webdav: Uploads</a>";
		    echo "<a class='btn btn-secondary' href='webdav://cloud.oeh-tnf.at/LVAs/$name/'>Webdav: LVA-Folder</a>";
		}
	    }
	    ?>
	</div>
    </body>
</html>

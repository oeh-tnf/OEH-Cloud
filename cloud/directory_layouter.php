<?php
// Internal LVA Names. NEVER CHANGE THESE!
$lvas = [
    1 => "Digitale Schaltungen",
    2 => "Praktikum Digitale Schaltungstechnik"
];

// If the name of a program is changed, nothing 
// happens. The old one must be deleted though.
$studien = [
    "Bachelorstudium Informatik" => [
	skz => [521],
	courses => [
	    "Digitale Schaltungen" => 1,
	    "Praktikum Digitale Schaltungstechnik" => 2
	]
    ],
    "Bachelorstudium Mechatronik" => [
	skz => [512],
	courses => [
	    "PR Digitale Schaltungstechnik" => 2
	]
    ]
];

$current_dir = dirname(__FILE__);
$LVAs_dir = $current_dir . "/LVAs/";
$Studi_dir = $current_dir . "/Programs/";

$actions = "";
$errors = "";

// Create folders and symlinks.
foreach($lvas as $id => $lva) {
    $dir = $LVAs_dir . "/" . $lva;
    if(!file_exists($dir)) {
	mkdir($dir);
	$actions .= "<li>Create directory $dir for $lva.</li>";
    }

    $link = $dir . "/upload.php";
    if(!file_exists($link)) {
	symlink($current_dir . "/upload.php", $link);
	$actions .= "<li>Link upload.php for $lva.</li>";
    }
}

foreach($studien as $name => $data) {
    $dir = $Studi_dir . "/" . $name;

    if(!file_exists($dir)) {
	mkdir($dir);
	$actions .= "<li>Create directory $dir for $name.</li>";
    }

    $link = $dir . "/review-todo.php";
    if(!file_exists($link)) {
	symlink($current_dir . "/review-todo.php", $link);
	$actions .= "<li>Link review-todo.php for $name.</li>";
    }

    foreach($data["courses"] as $link => $tgt) {
	$lva_link = $dir . "/" . $link;
	$lva_dir = $LVAs_dir . "/" . $lvas[$tgt];

	if(!file_exists($lva_dir)) {
	    $errors .= "<li>Cannot link $lva_dir to $lva_link in directory $dir, as $lva_dir does not exist!</li>";
	    continue;
	}
	if(file_exists($lva_link)) {
	    continue;
	}
	
	symlink($lva_dir, $lva_link);
	$actions .= "<li>Link $lva_dir to $lva_link in directory $dir.</li>";
    }
}

?>
<html>
    <head>
	<title>Create Layout for ÖH Cloud</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/bootstrap.min.css">
    </head>
    <body>
	<div class="container">
	    <div class="jumbotron">
		<h1>Create Layout for ÖH Cloud</h1>
		<p>This page ensures the defined ÖH cloud layout is enabled. Once it is visited, all
		    required folders and links are created based on the given plan.</p>
	    </div>

	    <?php
	    echo "<ul>$actions</ul>\n";
	    echo "<ul color='red'>$errors</ul>\n";
	    ?>
	</div>
    </body>
</html>

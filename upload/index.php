<?php


function die404() {
	http_response_code(404);
	die();
}


if (!isSet($_GET['link'])) die404();
$name = $_GET['link'];
if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) die404();

$data = __DIR__.'/'.strtolower($name).'/update.json';
if (!file_exists($data)) die404();
$time = (isSet($_GET['timestamp']) && intval($_GET['timestamp'])) ? (intval($_GET['timestamp'])) : time();
$json = json_decode(file_get_contents($data), JSON_OBJECT_AS_ARRAY);
$minDiff = PHP_INT_MAX;
foreach($json['uploads'] as $key => $value) {
	$diff = $time - intval($key);
	if ($diff < 0) continue;
	if ($diff < $minDiff) {
		$minDiff = $diff;
		$sha = $value['sha1'];
	}
}
if (!$sha) die404();
if (!($file = $json['files'][$sha]['file'])) die404();
header("Content-Type: application/zip");
header("Content-Transfer-Encoding: Binary");
header("Content-Length: ".filesize($file));
header("Content-Disposition: attachment; filename=\"".$name.".zip\"");
readfile($file);

?>
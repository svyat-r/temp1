<?php

$img = getenv('BANNER_IMG');
define('PUBLIC_DIR', dirname(__FILE__));

// Better to use object of Singletone config class
$dbConfig = [
	getenv('DB_HOST'),
	getenv('DB_USER'),
	getenv('DB_PASSWORD'),
	getenv('DB_NAME'),
];

if (!isset($_SERVER['REMOTE_ADDR']) || !isset($_SERVER['HTTP_USER_AGENT']) || !isset($_SERVER['HTTP_REFERER'])) {
	error_log('Wrong params');
	return returnImage($img);
}

$db = new mysqli(...$dbConfig);
if ($db->connect_error) {
	error_log('Connection failed: ' . $db->connect_error);
	return returnImage($img);
}

$ip = ip2long($_SERVER['REMOTE_ADDR']);
$userAgent = htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
$pageUrl = htmlspecialchars($_SERVER['HTTP_REFERER'], ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare('INSERT INTO banner_views (ip_address, user_agent, page_url, view_date, views_count)
    VALUES (?, ?, ?, NOW(), 1)
    ON DUPLICATE KEY UPDATE
    view_date = NOW(), views_count = views_count + 1');
if (!$stmt) {
	error_log('Prepare failed: (' . $conn->errno . ') ' . $conn->error);
	return returnImage($img);
}
$stmt->bind_param(
	'iss',
	$ip,
	$userAgent,
	$pageUrl,
);

if ($stmt->execute()) {
	return returnImage($img);
} else {
	error_log('Error: ' . $stmt->error);
	return returnImage($img);
}

function returnImage($imgPath) {
	header('Content-Type: image/png');
	$imgFullPath = PUBLIC_DIR . DIRECTORY_SEPARATOR . $imgPath;
	if (file_exists($imgFullPath)) {
		readfile($imgFullPath);
	} else {
		// Will return empty image
		error_log('Can not find image path: ' . $imgFullPath);
	}
}



?>
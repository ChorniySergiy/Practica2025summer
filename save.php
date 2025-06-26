<?php
require __DIR__ . '/bootstrap.php';

//var_dump($_POST);exit;
if (!empty($_POST['ma5_content']) && !empty($_POST['email_id'])) {
	//$emailId = 131;
	$stmt = $conn->prepare("UPDATE emails SET custom_html = ? WHERE id = ?");
	//$stmt->execute([$_POST['ma5_content'], $emailId);
	$stmt->execute([$_POST['ma5_content'], (int)$_POST['email_id']]);
}
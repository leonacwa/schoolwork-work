<?php

function uploadfile($file, $strToPath) {

	if ($file["error"] > 0) {
		return "上传发生错误！{$file['error']}";
	} else {
		/*
		echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		echo "Type: " . $_FILES["file"]["type"] . "<br />";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
		 */
		$ok = true;
		if (file_exists($strToPath)) {
			if (false == unlink($strToPath)) {
				$ok = false;
			}
		}

		if ($ok) {
			if (move_uploaded_file($file["tmp_name"], $strToPath)) {
				return true;
			} else {
				return "上传失败！";
			}
		} else {
			return "上传失败！";
		}
	}
	return false;
}

?>

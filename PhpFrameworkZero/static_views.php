<?php

require_once "PhpFrameworkZero/Template.php";

$static_base = function($scope) {
	foreach (scandir(".") as $dir) {
		$path = $dir."/static/".$scope["matches"]["filename"];
		if (is_file($path)) {
		require $path;
		break;
		}
	}
	if (endswith(".css", $scope["matches"]["filename"])) header("Content-type: text/css; charset: UTF-8");
	return true;
};

$static_namespaced = function($scope) {
	foreach (scandir(".") as $dir) {
		$path = $dir."/static/".$scope["matches"]["namespace"]."/".$scope["matches"]["filename"];
		if (is_file($path)) {
		require $path;
		break;
		}
	}
	if (endswith(".css", $scope["matches"]["filename"])) header("Content-type: text/css; charset: UTF-8");
	return true;
};

?>

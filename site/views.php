<?php

require_once "PhpFrameworkZero/Template.php";

// execute a template in one row
$index_view = function($scope) {
	renderTemplate("home.php");
	return true;
};
$projects_view = function($scope) {
	renderTemplate("projects.php");
	return true;
};
$about_view = function($scope) {
	renderTemplate("about.php");
	return true;
};

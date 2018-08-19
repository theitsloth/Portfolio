<?php

require_once "config.php";

// Error log, if debug.
if ($DEBUG) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}

require_once "PhpFrameworkZero/PathRouter.php";
require_once "PhpFrameworkZero/functions.php";
require_once "PhpFrameworkZero/static_views.php";

$router = new PathRouter([
	$STATIC_PATH."/<string:filename>" => $static_base,
	$STATIC_PATH."/<string:namespace>/<string:filename>" => $static_namespaced,
	"" => require("routing.php"),
]);

/**
 * SCOPE specification
 * path: starts with a slash, ends with none. Contains the path.
 * matches: Array to be filled with the value of route variables.
 * session: Sub-session is necessary for modules to manage their data separately
 */
$scope = [
	"path" => "/".trim($_GET["q"], "/"),
	"matches" => array(),
];
if (!$router->execute($scope)) echo "404";

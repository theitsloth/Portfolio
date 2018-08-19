<?php

require_once "PhpFrameworkZero/functions.php";

$prefix__extended;
$prefix__blocks;
function extend($name) {
	global $prefix__extended;
	$prefix__extended = $name;
}
function startblock($name) {
	global $prefix__blocks;
	$prefix__blocks[0] = $name;
	ob_start();
}
function endblock() {
	global $prefix__blocks;
	$prefix__blocks[$prefix__blocks[0]] = ob_get_clean();
	unset($prefix__blocks[0]);
}
function block($name) {
	global $prefix__blocks;
	if (isset($prefix__blocks[$name]))
		echo $prefix__blocks[$name];
}
function isblock($name) {
	global $prefix__blocks;
	return isset($prefix__blocks[$name]);
}
function renderTemplate($prefix__filename, $prefix__context = array()) {
	global $prefix__extended, $prefix__blocks;
	// Create variables
	foreach ($prefix__context as $prefix__name => $prefix__value) {
		$$prefix__name = $prefix__value;
	}

	// ===== PRE =====
	// block
	$prefix__blocks = array();

	// ===== RENDER =====
	$prefix__loopguard = 20;
	do {
		$prefix__found = false;
		foreach (scandir(".") as $prefix__dir) {
			$prefix__path = $prefix__dir."/templates/".$prefix__filename;
			if (is_file($prefix__path)) {
				$prefix__extended = "";
				require $prefix__path;
				$prefix__filename = $prefix__extended;
				$prefix__found = true;
				break;
			}
		}
		if (!$prefix__found) throw new Exception("Template not found!");
		$prefix__loopguard--;
	} while (($prefix__filename != "") && $prefix__loopguard);
}

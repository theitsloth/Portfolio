<?php

require_once("PhpFrameworkZero/PathRouter.php");

return new PathRouter([
	"" => require("site/routing.php"),
]);

?>

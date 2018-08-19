<?php

require_once "PhpFrameworkZero/functions.php";

/**
 * Router for handling different paths
 *
 * A stackable routing element. On execution, it calls a different handler based on the request path.
 */
class PathRouter {
	/**
	 * Creates PathRouter from an array.
	 *
	 * The array should be in the form of "path expression" => action
	 * where action is a function or a {@link PathRouter}
	 */
	public function __construct( $in_array ) {
		$temp = array();
		foreach ($in_array as $in_path => $in_action) {
			// preg_quote for escaping regex
			$is_end = is_callable($in_action); // TODO: make this make sense.
			$regex = $this->path_to_regex($in_path, $is_end);
			if ($in_action instanceof PathRouter) {
				$temp[$regex] = [$in_action, "execute"];
			}
			else if (is_callable($in_action)) {
				$temp[$regex] = $in_action;
			}
			else if (is_string($in_action)) {
				$temp[$regex] = function($scope) {
					require_once $in_action;
				};
			}
			else {
				die("Bad path handler for path".$in_path);
			}
		}
		$this->paths = $temp;
	}

	/**
	 * INTERNAL Executes the router on the scope, then passes the result to the right handler.
	 *
	 * @param	array	$scope	The scope to operate on. See the scope specification.
	 * @return	mixed	The return value of the handler, or boolean false if no handler matched.
	 */
	public function execute($scope) {
		$path = $scope["path"];
		foreach ($this->paths as $regex => $handler) {
			if ($this->preg_match_path($regex, $path, $scope["matches"], $scope["path"])) {
				return $handler($scope);
			}
		}
		return false;
	}

	/**
	 * Turns a path expression into a regular expression
	 *
	 * @param	string	$in_path	The path expression
	 * @param	bool	$is_end	Allow subpath?
	 * @return	string	Regular expression with accurate named groups
	 */
	private function path_to_regex($in_path, $is_end) {
		preg_match_all("/(?P<var>\<(?P<var_type>[a-z]+)\:(?P<var_name>[a-z_]+)\>)/", $in_path, $matches);
		$path = preg_quote($in_path);
		$path = preg_replace("/\//", "\\/", $path); // Stupid regex
		for ($i = 0; $i < count($matches["var"]); $i++) {
			$regex = "(?P<".$matches["var_name"][$i].">";
			switch ($matches["var_type"][$i]) {
				case 'string':
					$regex .= "[a-zA-Z0-9_\\.\\-]+";
					break;
				case 'int':
					$regex .= "[0-9]+";
					break;
				default:
					continue;
					break;
			}
			$regex .= ")";
			$path = str_replace_first(preg_quote($matches["var"][$i]), $regex, $path);
		}
		$path = "/^".$path;
		if ($is_end) $path .= "$";
		$path .= "/";
		return $path;
	}

	/**
	 * Path matcher.
	 *
	 * Returns false or the subpath and loads new matches onto the array.
	 * @param	string	$regex	The regular expression to match with
	 * @param	string	$path	The path to match
	 * @param	array	$matches	The array to be filled with the named groups.
	 * @param	string	$ret_path	The remaining path will be put here.
	 * @return	mixed	boolean false or the end of the path that didn't match (or true if $ret_path is set).
	 */
	private function preg_match_path($regex, $path, &$matches = array(), &$ret_path = false) {
		if (!preg_match($regex, $path, $all_matches)) return false;
		foreach ($all_matches as $index => $value) {
			if (!is_numeric($index)) $matches[$index] = $value;
		}
		if ($ret_path === false) {
			return substr($path, strlen($all_matches[0]));
		}
		$ret_path = substr($path, strlen($all_matches[0]));
		return true;
	}
}

?>

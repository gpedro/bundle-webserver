<?php

$request_method = $_SERVER['REQUEST_METHOD'];

/* GET request should send information collector script */
if ($request_method == 'GET') {
	exit(file_get_contents('collector.sh'));
}

/* POST request should send specific installer script */
elseif ($request_method == 'POST') {
	/* HTTP servers */
	$http = array(
		'available' => array('apache', 'nginx'),
		'default'   => 'nginx',
		'chosen'    => null,
	);

	/* PHP runtimes */
	$php = array(
		'available' => array('hhvm', 'php'),
		'default'   => 'hhvm',
		'chosen'    => null,
	);

	/* REQUEST_URI contains the options */
	$options = array_filter(explode('/', $_SERVER['REQUEST_URI']));

	foreach($options as $option) {

		/* Try to find HTTP server */
		if (in_array($option, $http['available'])) {
			if (!$http['chosen']) {
				$http['chosen'] = $option;
				continue;
			} else {
				exit('Multiple choice for HTTP server.');
			}
		}

		/* Try to find PHP runtime */
		elseif (in_array($option, $php['available'])) {
			if (!$php['chosen']) {
				$php['chosen'] = $option;
				continue;
			} else {
				exit('Multiple choice for PHP interpreter.');
			}
		}

		/* Option is neither HTTP server nor PHP runtime */
		exit("Unknown option: {$option}");
	}

	/* Setting the default values if something was omitted */
	if (!$http['chosen']) $http['chosen'] = $http['default'];
	if (!$php['chosen']) $php['chosen'] = $php['default'];
}

?>

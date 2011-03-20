<?php
define('ZIPCODE_URL', 'http://www.israelpost.co.il/zip_data.nsf/SearchZip?');
//?OpenAgent&Location=<location>&POB=<pob>&Street=<street>&House=<house>&Entrance=');

function GET_or_default($key, $default)
{
	if (!empty($_GET[$key])) {
		return $_GET[$key];
	} else {
		return $default;
	}
}

function print_out($success, $zipcode = null)
{
	if ($success) {
		header('Status: 200 OK');
	} else {
		header('Status: 500 Internal Server Error');
	}
	header('Content-Type: application/json');

	$result = array('success' => (bool) $success);

	if (!empty($result)) {
		$result['zipcode'] = $zipcode;
	}

	if (!$success) {
		$result['error'] = 'An error has occured. Maybe one of the parameters is missing?';
	}

	print json_encode($result);
	exit;
}

$location	= GET_or_default('location', 'תל אביב');
$pob		= GET_or_default('pob', null);
$street		= GET_or_default('street', null);
$house		= GET_or_default('house', null);

$params = array('OpenAgent' => '', 'location' => $location);

switch (TRUE) {
	case (!empty($pob)):
		$params['pob'] = $pob;
		break;
	case (!empty($street) && !empty($house)):
		$params['street'] = $street;
		$params['house'] = $house;
		break;
	default:
		print_out(false);
}

$result = @file_get_contents(ZIPCODE_URL . http_build_query($params));
$result = @preg_match('/<body(?:.*?)>\s*(?:RES)?(\d*)/', $result, $matches);

if ($result && !empty($matches[1])) {
	print_out(true, $matches[1]);
}
else {
	print_out(false);
}
?>

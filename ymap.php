<?php

define('YMAP_URI', 'http://ymap.co.il/Navigate.aspx?tab=1&CityNmS=%town%&StreetNmS=%street%&HouseNbrS=%num%');

define('DEFAULT_TOWN', 'תל אביב יפו');
define('DEFAULT_STREET', 'אבן גבירול');
define('DEFAULT_NUM', 100);

if (!empty($_GET['q']))
{
	$town 	= DEFAULT_TOWN;
	$num	= DEFAULT_NUM;
	$street = DEFAULT_STREET;

	$s = (string)$_GET['q'];
	if (preg_match('/^[^0-9]*/', $s, $_street) && !empty($_street[0]))
	{
		$street = trim($_street[0]);
		$s = trim(preg_replace('/' . preg_quote($street) . '/', '', $s));
		if (preg_match('/^[0-9]*/', $s, $_num) && !empty($_num[0]))
		{
			$num = (int)trim($_num[0]);
		}
		if (preg_match('/,([\s\S]*)/', $s, $_town) && !empty($_town[1]))
		{
			$town = trim($_town[1]);
		}
	}

	if ($town && $num && $street)
	{
		$town	= mb_convert_encoding($town,	'ISO-8859-8', 'UTF-8');
		$num	= mb_convert_encoding($num,		'ISO-8859-8', 'UTF-8');
		$street	= mb_convert_encoding($street,	'ISO-8859-8', 'UTF-8');
	
		$pat = array('/\%town\%/', '/\%street\%/', '/\%num\%/');
		$rep = array($town, $street, $num);
		$rep = array_map('urlencode', $rep);
		$uri = preg_replace($pat, $rep, YMAP_URI);
	
		header('Location: ' . $uri);
		exit();	
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl">
<head>
<title>Ymap Quicksearch</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<form action="ymap.php" method="get">
<label for="q" style="display: block;"><?=DEFAULT_STREET?> <?=DEFAULT_NUM?>, <?=DEFAULT_TOWN?></label>
<input type="text" id="q" name="q" value="" /><input type="submit" value="חפש" />
</form>
</body>
</html>

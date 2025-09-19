<?php

ini_set('memory_limit', '1024M');
$files = glob("../common/images/*");

foreach($files as $f)
{
	if (is_dir($f))
		$dirs[] = $f;
}

print("<pre>");

foreach($dirs as $f)
{
var_dump($f);
//if (strpos($f, 'brshop') === false)
//	continue;

	$files = glob($f.'/*.[jJ][pP]*');
	
	foreach($files as $f2)
	{
		if (strpos($f2,'.webp') !== false)
			continue;
		if (file_exists($f2.'.webp') !== false)
			continue;

var_dump($f2);
		if (!is_dir($f2))
		{
			$jpg = @imagecreatefromjpeg($f2);
var_dump($jpg);
			if ($jpg !== false)
			{
				$webp = imagewebp($jpg, $f2.'.webp');
var_dump($webp);
				imagedestroy($jpg);
			}
		}
	}
}


print("</pre>");
exit;

?>

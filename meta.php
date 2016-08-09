<?php
//todo: basepaths
class Meta {
	static function start($arr = '') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="author" href="mailto:DanielFGray@gmail.com"/>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1"/>
<meta name="viewport" content="width=device-width"/>
<?php
		self::printTitle(isset($arr['title']) ? $arr['title'] : '');
		self::printStyles(isset($arr['styles']) ? $arr['styles'] : '');
		self::printScripts(isset($arr['scripts']) ? $arr['scripts'] : '');
	}
	static function printTitle($str = '') {
		if(!empty($str))
			$str .= ' ';
?>
<title><?php echo $str;?>::DFGray</title>
<?php
	}
	static function printStyles($var = '') { ?>
<link rel="stylesheet" type="text/css" href="http://dfgray.pcriot.com/styles/html5reset.css"/>
<?php if(file_exists('style.css')) :?>
<link rel="stylesheet" type="text/css" href="http://dfgray.pcriot.com/modes/style.css"/>
<?php endif;
	}
	static function printScripts($var = array()) {?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<?php if(file_exists('script.js')): ?>
<script src="http://dfgray.pcriot.com/modes/script.js"></script>
<?php endif;
	}
}
?>
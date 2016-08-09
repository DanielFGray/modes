<?php
/**
 * @package MusicTheoryByCode
 * @author Daniel Gray <DanielFGray@gmail.com>
 * @copyright 2010
 */
if(!class_exists('MusicalObject'))
	require 'modes.phps';
if(!class_exists('Meta'))
	require $_SERVER['DOCUMENT_ROOT'].'/meta.php';
Meta::start(array(
	'title' => 'Modes Cheat Sheet',
	'scripts' => array('jquery')
));
?>
<style type="text/css">
body {
  line-height: 1.5em;
  font-family: sans;
  color: #222;
  background-color: #eee;
}
pre, code {
  font-family: "Fantasque Sans Mono" "monospace" !important;
  color: #000;
  background-color: #ddd;
  padding: 10px;
  display: inline-block;
  border-radius: 9px;
}

#main {
  padding: 30px;
  max-width: 700px;
  margin: 0 auto;
}
</style></head>
<body>
<div id="wrapper">
<div id="modeSelector">
	<div id="controls">
		<form>
			<select name="key" size="12">
<?php foreach(MusicalObject::$lame as $i => $name):?>
				<option value="<?php echo $i;?>"><?php echo $name;?></option>
<?php endforeach;?>
			</select>
			<br />
			<input type="checkbox" id="relatives"/><label for="relatives">relatives</label>
		</form>
		<div id="ajax"></div>
	</div>
	<div id="table">
		<table>
<?php foreach(MusicTheory::getAllModes('C') as $m):?>
			<tr>
				<td class="name"><?php echo $m['name'];?></td>
				<td class="steps"><?php echo $m['steps'];?></td>
				<td class="degrees"><?php echo $m['degrees'];?></td>
				<td class="key"><?php echo $m['key'];?></td>
			</tr>
<?php endforeach;?>
		</table>
	</div>
</div>
</div>
</body>
</html>

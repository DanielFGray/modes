<?php
/**
 * @package MusicTheoryByCode
 * @author Daniel Gray <DanielFGray@gmail.com>
 * @copyright 2010
 */

abstract class MusicalObject {

  static
    $degrees = array('R', 'm2', 'M2', 'm3', 'M3', 'P4', array('A4', 'D5'), 'P5', 'm6', 'M6', 'm7', 'M7'),
    $lame = array('C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'),
    $modeNames = array('Ionian', 'Dorian', 'Phrygian', 'Lydian', 'Mixolydian', 'Aeolian', 'Locrian'),
    $getScale = array(
      'Major'               => array(2,2,1,2,2,2,1),
      'Natural Minor'       => array(2,1,2,2,1,2,2),
      'Harmonic Minor'      => array(2,1,2,2,1,3,1),
      'Diminished Arpeggio' => array(3,3,3,3)
    );

  static function iterate(array $arr, $offset, array $alg = null) {
    $return = array();
    $count = $height = count($arr);
    if(!empty($alg)) {
      $return[] = $arr[$offset];
      $count = count($alg);
    }

    for($i = 0, $j = 0; $i < $count; $i++) {
      $point = $offset + (!empty($alg) ? $j += $alg[$i] : $i);
      if($point >= $height)
        $point -= $height;
      $return[] = $arr[$point];
    }
    return $return;
  }
}

class MusicalScale extends MusicalObject {

  protected
    $spaces = array(),
    $scale = array();

  public function __construct() {
    $arr = func_get_args();
    if(func_num_args() == 1) {
      $arr = func_get_arg(0);
      if(is_string($arr))
        $arr = self::stringToScale($arr);
      elseif(is_array($arr)) {
        if(is_array($arr[0]))
          $arr = $arr[0];
        if(count($arr) == 1 and is_string($arr[0]))
          $arr = self::stringToScale($arr[0]);
      }
    }
    $arr = self::isRealScale($arr);
    if(!empty($arr))
      $this->setSpaces($arr);
    else
      throw new Exception('no known scale');
  }

  private function setSpaces(array $arr) {
    $this->spaces = $arr;
    $this->inSteps();
    $this->inDegrees();
  }

  static function isRealScale(array $scale) {
    $r = false;
    $j = 0;
    foreach($scale as $i => $v)
      $j += $scale[$i];
    if($j == 12)
      $r = $scale;
    return $r;
  }

  static function stringToScale($str) {
    if(str_word_count($str, 0, '1234567890') > 3)
      $arr = explode(' ', $str);
    $str = ucwords($str);
    if(is_numeric($str))
      $arr = str_split($str);
    elseif(array_key_exists($str, self::$getScale) !== false)
      $arr = self::$getScale[$str];
    elseif($a = array_search($str, self::$modeNames) !== false)
      $arr = parent::iterate(self::$getScale['Major'],$a);
    if(is_array($arr) and !empty($arr))
      return $arr;
    return false;
  }

  static function getModeIndexByName($str) {
    $index = array_search(ucwords($str), self::$modeNames);
    return $index;
  }

  public function inSteps() {
    $this->scale['steps'] = array();
    foreach($this->spaces as $s)
      $this->scale['steps'][] = $s == 2 ? 'W' : 'H';
    return $this;
  }

  public function inDegrees() {
    $this->scale['degrees'] = self::iterate(self::$degrees, 0, $this->spaces);
    if($tt = array_search(self::$degrees[6], $this->scale['degrees']))
      $this->scale['degrees'][$tt] = ($tt == 4 ?
        $this->scale['degrees'][$tt][1] :
        $this->scale['degrees'][$tt][0]);
    array_pop($this->scale['degrees']);
    return $this;
  }

  public function inMode($pos) {
    if(!is_numeric($pos))
      $pos = self::getModeIndexByName($pos);
    $this->setSpaces(self::iterate($this->spaces, $pos));
    $this->scale['name'] = self::$modeNames[$pos];
    return $this;
  }

  public function inKey($key) {
    $this->scale['name'] = $key.' '.$this->scale['name'];
    if(!is_numeric($key))
      $key = array_search($key, self::$lame);
    $this->scale['key'] = self::iterate(self::$lame, $key, $this->spaces);
    #fixme: nicer notes
    return $this;
  }

  public function asArray($arr=null) {
    if(empty($arr))
      $arr = $this->scale;
    foreach($arr as $k => $v)
      if(is_array($v)) 
        $arr[$k] = implode(' ', $v);
    return $arr;
  }
}

abstract class MusicTheory extends MusicalObject {

  abstract function newChord();

  static function newScale() {
    return new MusicalScale(func_get_args());
  }

  static function getAllModes($key, $relatives=false) {
    $r = array();
    if(!empty($relatives))
      $keyA = parent::iterate(parent::$lame, array_search($key, parent::$lame), parent::$getScale['Major']);
    foreach(parent::$modeNames as $i=>$mode) {
      if(!empty($relatives))
        $key = $keyA[$i]; 
      $r[] = self::newScale('major')
        ->inMode($mode)
        ->inKey($key)
        ->asArray();
    }
    return $r;
  }
}

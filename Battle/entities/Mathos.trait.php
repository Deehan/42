<?php
trait Mathos{
/**
* Virtually draw a line from (x1, y1) to (x2, y2) using Bresenham algorithm, returning the coordinates of the points that would belong to the line.
* param $x1 (Int)
* param $y1 (Int)
* param $x2 (Int)
* param $y2 (Int)
* param $guaranteeEndPoint By default end point (x2, y2) is guaranteed to belong to the line. Many implementation don't have this. If you don't need it, it's a little faster if you set this to false.
* return (Array of couples forming the line) Eg: array(array(2,100), array(3, 101), array(4, 102), array(5, 103))
* Public domain Av'tW
*/
function bresenham($x1, $y1, $x2, $y2, $guaranteeEndPoint=false){
	$xBegin = $x1;
	$yBegin = $y1;
	$xEnd = $x2;
	$yEnd = $y2;
	$dots = array(); // Array of couples, returned array</p>

	$steep = abs($y2 - $y1) > abs($x2 - $x1);

	// Swap some coordinateds in order to generalize
	if ($steep) {
		$tmp = $x1;
		$x1 = $y1;
		$y1 = $tmp;
		$tmp = $x2;
		$x2 = $y2;
		$y2 = $tmp;
	}
	if ($x1 > $x2) {
		$tmp = $x1;
		$x1 = $x2;
		$x2 = $tmp;
		$tmp = $y1;
		$y1 = $y2;
		$y2 = $tmp;
	}
	$deltax = floor($x2 - $x1);
	$deltay = floor(abs($y2 - $y1));
	$error = 0;
	$deltaerr = $deltay / $deltax;
	$y = $y1;
	$ystep = ($y1 < $y2) ? 1 : -1;

	for ($x = $x1; $x < $x2; $x++) {
		$dots[] = $steep ? array('x'=>$y, 'y'=>$x) : array('x'=>$x, 'y'=>$y);      
		$error += $deltaerr;        
		if ($error >= 0.5) {
			$y += $ystep;
			$error -= 1;
		}
	} // end of line</p>

	if ($guaranteeEndPoint) {
// Bresenham doesn't always include the specified end point in the result line, add it now.
		if ((($xEnd - $x) * ($xEnd - $x) + ($yEnd - $y) * ($yEnd - $y)) <
			(($xBegin - $x) * ($xBegin - $x) + ($yBegin - $y) * ($yBegin - $y))) {
// Then we're closer to the end
			$dots[] = array('x'=>$xEnd, 'y'=>$yEnd);
		}
		else $dots[] = array('x'=>$xBegin, 'y'=>$yBegin);
	}
	return $dots;
}
function range($range){
	$chance=Dice::roll();
	switch ($chance) {
		case ($chance >=5):
			return 3;
		case ($chance >=3):
			return 2;
		case ($chance >=1):
			return 1;
		default:
			break;
	}
}
function shootable(Ship $src, Ship $tgt){
	$posa=$src->position();$posb=$tgt->position();
	if (length($posa, $posb) <= $this->longrange){
		$ligne=bresenham($posa['x'], $posa['y'], $posb['x'], $posb['y']);
		foreach($ligne as $key=>$point){
			foreach($src->allships() as $obstacle){
				if (is_in($point, $obstacle) && $obstacle->id()===$tgt->id()){
					return True;
				}elseif ($obstacle instanceof Obstacle && is_in($point, $obstacle))
					return False;
				elseif (is_in($point, $obstacle))
					return False;
			}
		}
	}
	return False;
}
function length(array $posa, array $posb){
	return floor(sqrt( pow(abs($posb['x']-$posa['x']), 2) * pow(abs($posb['y']-$posa['y']), 2)));
}
function is_in(array $position, Movable $objet){
	$aire=$object->get_area();
	if ( $position['x'] >= $aire['startx'] && $position['x'] <= $aire['endx'] &&
		$position['y'] >= $aire['starty'] && $position['y'] <= $aire['endy'] )
		return True;
	else
		return False;
}
}
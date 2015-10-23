<?php
class Obstacle  extends Basic_ent implements Movable{
	use Mathos;
	protected $position;
	protected $size;
	protected $image;
	function __construct(Application $app, array $var){
		parent::__construct($app, $var);
		$this->image='../images/obstacle.png';
	}
	function get_area(){ //un tableau d'aire de l'obstacle array(startx endx starty endy)
		return array('startx'=>$this->position['x']-($this->size['width']/2),
			'endx'=>$this->position['x']+($this->size['width']/2),
			'starty'=>$this->position['y']-($this->size['height']/2),
			'endy'=>$this->position['y']+($this->size['height']/2));
	}
	function setposition($x, $y){$this->position['x'] = $x; $this->position['y'] = $y;}
}
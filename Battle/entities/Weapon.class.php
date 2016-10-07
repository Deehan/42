<?php
require_once "Mathos.trait.php";
class Weapon extends Basic_ent{
	use Mathos;
	protected $name;
	protected $munitions = 0;
	protected $firepower;
	protected $closerange;
	protected $midrange;
	protected $longrange;
	protected $splash;
	protected $charge_time=0;
	protected $weapons;
	function __construct(Application $app, $var){parent::__construct($app);}

	function charge_munitions($var){ //chargement de munitions, attend un entier
		if (is_numeric($var))
			$this->munitions=$var;
	}

	function shoot(Ship $shooter, Ship $target){
		$chance=Dice::roll();
		$shoot=False;
		$range=0;
		switch ($portee) {
			case 'long':
				if ($chance>=5)
					$shoot=True;
				$range=$this->longrange;
				break;
			case 'mid':
				if ($chance>=3)
					$shoot=True;
				$range=$midrange;
				break;
			case 'close':
				if ($chance>=1)
					$shoot=True;
				$range=$closerange;
				break;
			default:
				break;
		}
		if (!$shoot) return False;
		$ligne=bresenham($shooter->position()['x'], $shooter->position()['y'], $target->position()['x'], $target->position()['y']);
		foreach($ligne as $key=>$point){
			foreach($this->allships() as $obstacle){
				if (is_in($point, $obstacle) && $obstacle->id()===$target->id()){
					$target->take_damage($this); return True;
				}elseif ($obstacle instanceof Obstacle && is_in($point, $obstacle))
					return False;
				elseif (is_in($point, $obstacle))
					return False;
			}
		}
	}

	public function __get($name)
	{
		switch($name)
		{
			case 'closerange':
			case 'midrange':
			case 'longrange':
			case 'splash':
			case 'weapons':
			case 'name':
				return $this->$name;
			break;
			default:
				return NULL;
		}
	}
}
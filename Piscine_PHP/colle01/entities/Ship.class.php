<?php
class Ship extends Basic_ent implements Movable{
	
	const FWD = 'forward';
	const LFT = 'turn_left';
	const RGT = 'turn_right';
	const SHT = 'shoot';
	static protected $spid=0; 
	protected $id;   //id=spid, pour donner un id unique a chaque vaisseau
	protected $name;
	protected $size=array(); //array('width'=>..., 'height'=>...)
	protected $sprite;
	protected $hpmax;
	protected $hp;   //points de coque
	protected $sp;   //points de bouclier
	protected $spmax;
	protected $speed;
	protected $moved=false;
	protected $maneuver; // Plus la valeur est grande est plus c'est dur a manoeuvrer
	protected $weapons=array(); //liste d'armes
	protected $position=array(); //Position du vaisseau dans le champs de bataille array('x'=>...,'y'=>...)
	protected $direction=array(); //direction du vaisseau array('x'=>...,'y'=>...)
	protected $power; // Puissance du moteur
	protected $image;
	protected $collided=False;
	protected $lastmove=0;

	function __construct(Application $app, array $var, $player){
		parent::__construct($app);
		$this->id=$this->spid;
		$this->spid++;
		$this->name=$var['name'];
		if ($player == 1){
			$this->direction['x']=1;
			$this->direction['y']=0;
		}else{
			$this->direction['x']=-1;
			$this->direction['y']=0;
		}
	}
	public function __get($name)
	{
		switch($name)
		{
			case 'id':
			case 'name':
			case 'size':
			case 'hp':
			case 'hpmax':
			case 'spmax':
			case 'sp':
			case 'speed':
			case 'moved':
			case 'maneuver':
			case 'position':
			case 'direction':
			case 'power':
			case 'image':
			case 'moved':
			case 'weapons':
				return $this->$name;
			break;
			default:
				return NULL;
		}
	}
	function setposition($x, $y){$this->position['x'] = $x; $this->position['y'] = $y;}
	function setpowers(array $arsenal){
		$powers=0;
		foreach ($arsenal as $key => $value) {
			switch ($key) {
				case 'move':
					$powers=$value;
					break;
				case 'shield':
					$this->repairShield($value);
					break;
				case 'hp':
					$this->repair($value);
					break;
				case 'shoot':
					$powers+=$value;
					break;
				default:
					break;
			}
		}
		return $powers;
	}
	function play_actions(array $actions){
		foreach ($actions as $key => $tab) {
			switch($tab['action']){
				case 'forward':
					$this->$tab['action']($tab['length']);
					break;
				case 'turn_left':
					$this->$tab['action']();
					break;
				case 'turn_right':
					$this->$tab['action']();
					break;
				case 'shoot':
					$this->$tab['action']();
					break;
				default:
					break;
			}
		}
	}
	function new_turn(){             //Fonction a appeler avant de commencer le tour du joueur sur tous ses vaisseaux vivants.
		if ($this->lastmove <= $this->maneuver){
			$this->moved=False;
			$this->lastmove=0;
		}elseif ($this->lastmove > $this->maneuver){
			$this->position['x']+=$this->maneuver*$this->direction['x'];
			$this->position['y']+=$this->maneuver*	$this->direction['y'];
			$this->lastmove=0;
			$this->moved=True;
		}
	}
	function get_area(){              //un tableau d'aire du vaisseau array(startx endx starty endy)
		if ($this->direction['x']!==0)
			return array('startx'=>$this->position['x']-($this->size['width']/2),
						'endx'=>$this->position['x']+($this->size['width']/2),
						'starty'=>$this->position['y']-($this->size['height']/2),
						'endy'=>$this->position['y']+($this->size['height']/2));
		else
			return array('startx'=>$this->position['x']-($this->size['width']/2),
						'endx'=>$this->position['x']+($this->size['width']/2),
						'starty'=>$this->position['y']-($this->size['height']/2),
						'endy'=>$this->position['y']+($this->size['height']/2));
	}
	function is_collide(Movable $a, Movable $b){ // verifie si les 2 bateaux se cognent
		$aireA=$a->get_area();
		$aireB=$b->get_area();
		if (
		($aireA['startx']>=$aireB['startx'] && $aireA['startx']<=$aireB['endx'] && $aireA['starty']>=$aireB['starty'] && $aireA['starty']<=$aireB['endy']) ||
		($aireA['startx']>=$aireB['startx'] && $aireA['startx']<=$aireB['endx'] && $aireA['endy']>=$aireB['starty'] && $aireA['endy']<=$aireB['endy']) ||
		($aireA['endx']>=$aireB['startx'] && $aireA['endx']<=$aireB['endx'] && $aireA['starty']>=$aireB['starty'] && $aireA['starty']<=$aireB['endy']) ||
		($aireA['endx']>=$aireB['startx'] && $aireA['endx']<=$aireB['endx'] && $aireA['endy']>=$aireB['starty'] && $aireA['endy']<=$aireB['endy'])
		)
			return True;
		else
			return False;
	}
	private function is_out(Ship $ship){
		$aire = $ship->get_area();
		if ($aire['startx'] < 0 || $aire['starty'] < 0 || $aire['endx'] >= 150 || $aire['endy'] >= 100)
			return True;
		return False;
	}
	function forward($length){ // longueur
		if ($this->hp === 0) return;
		$newx=$this->position['x']+($length*$this->speed)*$this->direction['x'];
		$newy=$this->position['y']+($length*$this->speed)*$this->direction['y'];

		for($i=$this->position['x'];$i<$newx;$i+=$this->direction['x']){
			foreach($this->allships() as $obstacle){
				$tmp=clone $this;
				$tmp->setposition($i, $tmp->position['y']);
				if ($obstacle instanceof Ship && $obstacle->id()!==$this->id && $this->is_collide($tmp, $obstacle)){
					$this->collision($obstacle);
					$obstacle->collision($tmp);
					$this->collided=True;
					$this->lastmove=abs($this->position['x']-$i);
					$this->position['x']=$newx;
					return;
				}elseif ($obstacle instanceof Obstacle && $this->is_collide($tmp, $obstacle)){$this->hp=0;return;} //collision d'obstacle
				if ($this->hp<=0) return;
			}
			if ($this->is_out($this)){$this->hp=0;return;} //depasse l'ecran
		}
		$this->position['x']=$newx;
		for($i=$this->position['y'];$i<$newy;$i+=$this->direction['y']){
			foreach($obs as $obstacle){
				$tmp=clone $this;
				$tmp->setposition($tmp->position['y'], $i);
				if ($obstacle instanceof Ship && $obstacle->id()!==$this->id && $this->is_collide($tmp, $obstacle)){
					$this->collision($obstacle);
					$obstacle->collision($tmp);
					$this->collided=True;
					$this->lastmove=abs($this->postion['y']-$i);
					$this->position['y']=$newy;
					return;
				}elseif ($obstacle instanceof Obstacle && $this->is_collide($tmp, $obstacle)){$this->hp=0;return;} //collision d'obstacle
				if ($this->hp<=0) return;
			}
			if ($this->is_out($this)){$this->hp=0;return;} //depasse l'ecran
		}
		$this->position['y']=$newy;
		$this->moved=True;
		$this->lastmove=$length;
	}
	function collision(Ship $ship){
		$a=($this->hp+$this->sp)-$ship->hp();
		if ($a<=0 || $this->hp<$a)
			$this->hp=0;
		elseif (($this->hp+$this->sp)>$a){
			$this->sp-=$a;
			if ($this->sp<0){
				$this->hp-=$this->sp;
				$this->sp=0;
			}
		}
	}
	function turn_left(){
		if ($this->collided) return;
		$x=$this->direction['x'];
		$y=$this->direction['y'];
		if ($x!==0) $this->direction['x']=0;
		elseif ($x==0 && $y>0) $this->direction['x']=-1;
		elseif ($x==0 && $y<0) $this->direction['x']=1;
		if ($y!==0) $this->direction['y']=0;
		elseif ($y==0 && $x>0) $this->direction['y']=1;
		elseif ($y==0 && $x<0) $this->direction['y']=-1;
		if ($this->move) $this->power-=1;
	}
	function turn_right(){
		if ($this->collided) return;
		$x=$this->direction['x'];
		$y=$this->direction['y'];
		if ($x!==0) $this->direction['x']=0;
		elseif ($x==0 && $y>0) $this->direction['x']=1;
		elseif ($x==0 && $y<0) $this->direction['x']=-1;
		if ($y!==0) $this->direction['y']=0;
		elseif ($y==0 && $x>0) $this->direction['y']=-1;
		elseif ($y==0 && $x<0) $this->direction['y']=1;
		if ($this->move) $this->power-=1;
	}
	function shoot(){
		if ($this->collided) return;
		foreach ($this->weapons as $weap) {
			$weap->shoot($this, $this->position, $this->direction);
		}
	}
	function repair($pp){$this->hp = min($this->hpmax, ($this->hp + $pp));}
	function repairShield($pp){$this->sp = min($this->spmax, ($this->sp + $pp));}
	function take_damage(Weapon $weapon) {
//		if ($weapon instanceof Emp){$this->sp=0; return;}
		$diff=$this->shield - $weapon->firepower;
		if ($diff<0){ $this->hp-=$diff; $this->shield=0;}
		else $this->shield-=$diff;
	}

	public function get_maneuvers(Array $moves)
	{
		$this->moved = false;
		$free = 0;
		$array = array();
		$count = 0;
		if (!$this->moved && count($moves) == 0)
		{
			$array[] = array('key'=>'FREE_TLEFT', 'free'=>true, 'compul'=>false, 'count'=>1);
			$array[] = array('key'=>'FREE_TRIGHT', 'free'=>true, 'compul'=>false, 'count'=>1);
		}
		foreach($moves as $key=>$val)
		{
			if ($val['free'])
				$free++;
			else
				$count += $val['count'];
		}
		$cpt = $this->speed - $count;
		if ($cpt > 0)
		{
			$array[] = array('key'=>'TLEFT', 'free'=>false, 'compul'=>false, 'count'=>$cpt);
			$array[] = array('key'=>'TRIGHT', 'free'=>false, 'compul'=>false, 'count'=>$cpt);
			$array[] = array('key'=>'FORW', 'free'=>false, 'compul'=>false, 'count'=>$cpt);
		}
		return $array;
	}
}
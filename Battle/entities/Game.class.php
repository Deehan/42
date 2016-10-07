<?php
class Game extends Basic_ent
{
	private $_p1 = NULL;
	private $_p2 = NULL;
	private $_turn;

	public function __construct(Application $app)
	{
		$this->_turn = 1;
	}

	public function setPlayer(Player $p, $num=1)
	{
		$num = $num == 1 ? '_p'.$num : '_p2';
		$this->$num = $p; 
	}

	public function player($num=1)
	{
		$num = $num == 1 ? '_p1' : '_p2';
		if ($this->$num instanceOf Player)
		return $this->$num;
	}
}
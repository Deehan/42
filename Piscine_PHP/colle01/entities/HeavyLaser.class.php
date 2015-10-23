<?php
class HeavyLaser extends Weapon{
	function __construct(Application $app, $var){
		parent::__construct($app, $var);
		$this->firepower=2;
		$this->closerange=7;
		$this->midrange=14;
		$this->longrange=21;
		$this->name='Heavy Laser';
	}
}
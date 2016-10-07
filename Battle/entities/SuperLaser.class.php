<?php
class SuperLaser extends Weapon{
	function __construct(Application $app, $var){
		parent::__construct($app, $var);
		$this->firepower=30;
		$this->closerange=7;
		$this->midrange=14;
		$this->longrange=21;
		$this->name='Super Laser';
	}
}
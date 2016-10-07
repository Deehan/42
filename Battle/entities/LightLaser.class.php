<?php
class LightLaser extends Weapon{
	function __construct(Application $app, $var){
		parent::__construct($app, $var);
		$this->firepower=1;
		$this->closerange=7;
		$this->midrange=14;
		$this->longrange=21;
		$this->name='Light Laser';
	}
}
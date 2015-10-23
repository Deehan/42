<?php
class Plasma extends Weapon{
	function __construct(Application $app, $var){
		parent::__construct($app, $var);
		$this->firepower=10;
		$this->closerange=5;
		$this->midrange=10;
		$this->longrange=15;
		$this->name='Plasma Beam';
	}
}
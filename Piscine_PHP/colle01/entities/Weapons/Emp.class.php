<?php
class Emp extends Weapon{
	function __construct(Application $app, $var){
		parent::__construct($app, $var);
		$this->firepower=0;
	}
}
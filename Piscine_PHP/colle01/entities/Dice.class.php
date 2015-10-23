<?php
class Dice extends Basic_ent
{
	protected function __construct(){}

	public static function roll($number, $value, $&log)
	{
		$ret = 0;
		for($x=0;$x<$number;$x++)
		{
			if (rand(1,6) > $value)
				$ret++;
		}
		return $ret;
	}
}
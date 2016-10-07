<?php
class Infos extends Basic_ctrl
{
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}

	public function ship_infos()
	{
		$keys = array('name', 'hp', 'hpmax', 'sp', 'spmax', 'pp', 'image', 'power');
		if (!isset($_GET['player']) || !isset($_GET['ship']))
			echo json_encode(array());
		$array = array();
		$player = $this->app->game()->player($_GET['player']);
		$ships = $player->getships();
		foreach ($ships as $k=>$ship) {
			if ($k == $_GET['ship'])
			{
				$weapon = $ship->weapons;
				$array['weapons'] = array();
				foreach ($weapon as $w)
					$array['weapons'][] = get_class($w);
				foreach($keys as $key)
					$array[$key] = $ship->$key;
				break;
			}
		}
		echo json_encode($array);
	}

	private function sortByKey($a, $b) {
    	return $a['key'] - $b['key'];
	}

	public function ship_maneuvers()
	{	
		$array = array();
		if (!isset($_GET['player']) || !isset($_GET['ship']))
			echo json_encode(array());
		else
		{
			$moves = json_decode($_GET['moves'], true);
			$player = $this->app->game()->player($_GET['player']);
			$ships = $player->getships();
			foreach ($ships as $k=>$ship) {
				if ($k == $_GET['ship'])
				{
					$array = $ship->get_maneuvers($moves);
					break;
				}
			}
			echo json_encode($array);
		}
	}
}
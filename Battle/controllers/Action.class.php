<?php
class Action extends Basic_ctrl
{

	public function moves()
	{
		$actions = array();
		if (!isset($_GET['player']) || !isset($_GET['ship']) || !isset($_GET['moves']))
			echo json_encode(array());
		else
		{
			$moves = json_decode($_GET['moves'], true);
			foreach($moves as $val)
			{
				switch($val['key'])
				{
					case 'FORW':
					case 'FREE_FORW':
						$actions[] = array('action'=>'forward', 'length'=>$val['count']);
					break;
					case 'TRIGHT':
					case 'FREE_TRIGHT':
						for($x=0;$x<$val['count'];$x++)
							$actions[] = array('action'=>'turn_left', 'length'=>1);
					break;
					case 'TLEFT':
					case 'FREE_TLEFT':
						for($x=0;$x<$val['count'];$x++)
							$actions[] = array('action'=>'turn_right', 'length'=>1);
					break;
					default:
					break;
				}				
			}

			$player = $this->app->game()->player($_GET['player']);
			$ships = $player->getships();
			$step = array();
			foreach ($ships as $k=>$ship) {
				if ($k == $_GET['ship'])
				{
					foreach ($actions as $act) {
						$oldpos = array(	'x'=>($ship->position['x'] - round( ($ship->direction['x'] != 0 ? $ship->size['width'] : $ship->size['height']) / 2, 0)) *10,
											'y'=>($ship->position['y'] - round( ($ship->direction['x'] == 0 ? $ship->size['width'] : $ship->size['height']) / 2,0)) *10);

						$ship->play_actions(array($act));
						$width = $ship->direction['x'] != 0 ? $ship->size['width']*10 - 1 : $ship->size['height']*10 - 1;
						$height = $ship->direction['x'] ==  0 ? $ship->size['width']*10 - 1 : $ship->size['height']*10 - 1;
						$newpos = array(	'x'=>($ship->position['x'] - round( ($ship->direction['x'] != 0 ? $ship->size['width'] : $ship->size['height']) / 2, 0)) *10,
											'y'=>($ship->position['y'] - round( ($ship->direction['x'] == 0 ? $ship->size['width'] : $ship->size['height']) / 2,0)) *10);
						$step[] = array('id'=>$k, 'w'=>$width, 'h'=>$height, 'direction'=>$ship->direction, 'oldpos'=>$oldpos,'newpos'=>$newpos, 'move'=>array('x'=>$newpos['x'] - $oldpos['x'], 'y'=>$newpos['y'] - $oldpos['y']));
					}
					break;
				}
			}
			if (empty($step))
				echo json_encode(array());
			echo json_encode($step);
		}
	}
}
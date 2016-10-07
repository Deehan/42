<?php
class Board extends Basic_ctrl
{
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}

	public function run()
	{
		$board = $this;

		$ships = $this->app->game()->player(1)->getships();
		$p1ships = array();
		$p2ships = array();
		foreach($ships as $k=>$ship)
		{

			$p1ships[] = array(	'p'=>1,
								'w'=>$ship->direction['x'] != 0 ? $ship->size['width']*10 - 1 : $ship->size['height']*10 - 1,
								'h'=>$ship->direction['x'] ==  0 ? $ship->size['width']*10 - 1 : $ship->size['height']*10 - 1,
								'x'=>($ship->position['x'] - round($ship->size['width'] / 2, 0)) *10,
								'y'=>($ship->position['y'] - round($ship->size['height'] / 2,0)) *10);
		}
		$ships = $this->app->game()->player(2)->getships();
		foreach($ships as $k=>$ship)
		{
			$p2ships[] = array(	'p'=>2,
								'w'=>$ship->direction['x'] != 0 ? $ship->size['width']*10 - 1 : $ship->size['height']*10 - 1,
								'h'=>$ship->direction['x'] ==  0 ? $ship->size['width']*10 - 1 : $ship->size['height']*10 - 1,
								'x'=>($ship->position['x'] - round($ship->size['width'] / 2, 0)) *10,
								'y'=>($ship->position['y'] - round($ship->size['height'] / 2,0)) *10);
		}
		include(_VIEW_DIR_.'game.php');
	}

	public function playerboard($num)
	{
		$player = $this->app->game()->player((int)$num);
		$ships = $player->getships();
		include(_VIEW_DIR_.'player.php');
	}

	public function initgame()
	{
		//unset($_SESSION['game']);
		if (!isset($_SESSION['game']) || !($_SESSION['game'] instanceOf Game))
		{
			$p1 = new Player($this->app, 'Joueur A', '#FF0000');
			$p2 = new Player($this->app, 'Joueur B', '#00FF00');

			$p1->initiate('Cuirassé Desolator');
			$p1->initiate('Cuirassé Despoiler');
			$p1->initiate('Cuirassé Emperor');
			$p1->initiate('Cuirassé Oberon');
			$p1->initiate('Cuirassé Retribution');

			$p2->initiate('Canonnièr\' Sovaj\'');
			$p2->initiate('Kroiseur Kitu');
			$p2->initiate('Vésso d\'attak Ravajeur');
			$p2->initiate('Vésso Kikass\'');
			$p2->initiate('Vésso Kikraint');

			$ships = $p1->getships();
			$p1ships = array();
			$p2ships = array();
			foreach($ships as $k=>$ship)
			{
				$ship->setposition(rand($ship->size['width']/2+3,$ship->size['width']/2+6), $k+5 * 3 + $k *10);
			}
			$ships = $p2->getships();
			foreach($ships as $k=>$ship)
			{
				$ship->setposition(rand($ship->size['width']/2+3,$ship->size['width']/2+6), $k+5 * 3 + $k *10);
			}

			$_SESSION['game'] = new Game($this->app);
			$_SESSION['game']->setPlayer($p1);
			$_SESSION['game']->setPlayer($p2, 2);
		}
		$this->app->setGame($_SESSION['game']);
	}
}
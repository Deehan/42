<?php
abstract class Basic_ent extends Component
{
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}
	protected function allships(){
		$obs=array();
		$obs[]=$this->app->game()->player(1)->getships();
		$obs[]=$this->app->game()->player(2)->getships();
		return $obs;
	}
	public function doc()
	{
		$classname = get_class($this);
		if (file_exists(_DOC_DIR_.'entities/'.$classname.'.doc.txt'))
			return file_get_contents(_DOC_DIR_.'entities/'.$classname.'.doc.txt');
	}
}
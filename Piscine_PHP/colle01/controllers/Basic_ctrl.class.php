<?php
abstract class Basic_ctrl extends Component
{
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}

	public function doc()
	{
		$classname = get_class($this);
		if (file_exists(_DOC_DIR_.'controllers/'.$classname.'.doc.txt'))
			return file_get_contents(_DOC_DIR_.'controllers/'.$classname.'.doc.txt');
	}
}
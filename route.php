<?php

class Route
{
	/**
	* @var array $listUri List of URI's to match against
	*/
	private $listUri = [];

	/**
	* @var array $listCall List of closures to call
	*/
	private $listCall = [];

	/**
	* add - Adds a URI and Function
	*
	* @param string $uri path
	* @param object $function anonymous function
	*/
	public function add($uri, $function)
	{
		$uri = $this->trim($uri);
		$this->listUri[] = $uri;
		$this->listCall[] = $function;
	}

	public function trim($str){

		$trim = '/\^$';
		$str = ltrim($str, $trim);
		$str = trim($str, $trim);
		return $str;
	}

	/**
	* run - match URI and runs function
	*/
	public function run()
	{

		$uri = isset($_GET['url']) ? $_GET['url'] : '/';

		$uri = $this->trim($uri);

		$replacementValues = [];

		foreach ($this->listUri as $listKey => $listUri)
		{
			if (preg_match("#^$listUri$#", $uri))
			{
				$realUri = explode('/', $uri);
				$fakeUri = explode('/', $listUri);

				foreach ($fakeUri as $key => $value)
				{
					if ($value == '.+')
					{
						$replacementValues[] = $realUri[$key];
					}
				}

				call_user_func_array($this->listCall[$listKey], $replacementValues);
			}
		}
	}
}

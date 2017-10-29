<?php
namespace lib\Service\Conf;

class Configuration{
	
private $configArray = [];
	
	/**
	 * コンストラクタ
	 * @access public
	 */
	public function __construct()
	{
		$iniFile ="./configuration.ini";
		$this->configArray = parse_ini_file($iniFile, true);
		print_r($this->configArray);
	}
	
	/**
	 * iniファイルからのgetter section keyを指定
	 * @access public
	 * @param string $section,$key セクション名　キー名
	 */
	public function get($section,$key)
	{
		return $this->configArray[$section][$key];
	}
}
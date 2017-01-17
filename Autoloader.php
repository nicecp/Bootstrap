<?php
/**
 * Autoloader(命名空间，自动加载类)
 *
 * @author Chen Peng(forward.nice.cp@gmail.com)
 */

namespace Bootstrap;

class Autoloader {

	// 站点根目录，可配置多个子目录
	protected $dominRoot = array();

	public function __construct()
	{
		$this->domainRoot = array(
			// 默认目录上层两级目录为根目录
			__DIR__ . '/../../',
			__DIR__ . '/../',
			);
	}

	public static function instance()
	{
		return new static;
	}

	// 设置站点根目录
	public function setRoot($root = '')
	{
		if (!$root || !is_dir(realpath($root))) {
			throw new \Exception('No root param export or invalid path');
		}

		$this->domainRoot[] = realpath($root);
		return $this;
	}

	protected function autoloader($class)
	{
		$file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

		foreach ($this->domainRoot as $path) {
			clearstatcache();
			$path = $path . $file;
			if (is_file($path)) {
				require_once $path;
				if (class_exists($class, false)) {
					return true;
				}
			}
		}

		return false;
	}
	// 初始化
	public function init()
	{
		spl_autoload_register(array($this, 'autoloader'));

		return $this;
	}
}

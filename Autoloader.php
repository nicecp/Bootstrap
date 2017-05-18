<?php
/**
 * Autoloader(命名空间，自动加载类)
 *
 * @author Chen Peng(forward.nice.cp@gmail.com)
 */

namespace Bootstrap;

class Autoloader {

	// 站点根目录，可配置多个子目录
	protected $domainRoot = array();

	public function __construct()
	{
		$this->domainRoot = array(
			// 默认目录上层两级目录为根目录
			__DIR__ . '/../../',
			__DIR__ . '/../',
			);
	}

	/**
	 * 清空当前web目录
	 *
	 * @return object
	 */
	public function clear()
	{
		$this->domainRoot = array();

		return $this;
	}

	/**
	 * 返回当前实例
	 *
	 * @return object
	 */
	public static function instance()
	{
		return new static;
	}

	/**
	 * 设置web目录
	 *
	 * @param sting $root
	 * @return object
	 */
	public function setRoot($root = '')
	{
		if (!$root || !is_dir(realpath($root))) {
			throw new \Exception('No root param export or invalid path');
		}

		$this->domainRoot[] = realpath($root);
		return $this;
	}

	/**
	 * Autoloader 核心方法，加载对应文件
	 *
	 * @param string $class
	 * @return bool
	 */
	protected function autoloader($class)
	{
		$file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
		foreach ($this->domainRoot as $path) {
			clearstatcache();
			$path = $path . DIRECTORY_SEPARATOR .  $file;
			if (is_file($path)) {
				require_once $path;
				if (class_exists($class, false)) {
					return true;
				}
			}
		}

		return false;
	}
	
	/**
	 * 初始化
	 *
	 * @return object
	 */
	public function init()
	{
		spl_autoload_register(array($this, 'autoloader'));
		return $this;
	}
}

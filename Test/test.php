<?php
# 测试脚本

require_once __DIR__ . '/../Autoloader.php';

\Bootstrap\Autoloader::instance()->init();

$object = new \Bootstrap\Test\TestClass();

$object->T('TT');  // 输出‘TT’;
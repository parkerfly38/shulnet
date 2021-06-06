<?php

abstract class AAction {

    protected $m_config;

    public function setConfig($config) { $this->m_config = $config; }

	public abstract function getName();
	public abstract function run($req);

	protected function validateBoolean($b, $defaultValue) { return $b === null ? $defaultValue : $b; }
	protected function validateInteger($i, $defaultValue) { return $i === null ? $defaultValue : $i; }
	protected function validateString($s, $defaultValue) { return $s === null ? $defaultValue : $s; }

}

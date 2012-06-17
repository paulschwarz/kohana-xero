<?php
/**
 * @package
 * @author      Paul Schwarz <paulsschwarz@gmail.com>
 * @copyright   2012 Paul Schwarz
 * Date         17/06/12 15:19
 */
class X_Config {

    public function __construct()
    {
        $this->_config = Kohana::$config->load('xero');
    }

    public function consumer_key()
    {
        return Arr::path($this->_config, 'consumer.key');
    }

    public function consumer_secret()
    {
        return Arr::path($this->_config, 'consumer.secret');
    }

    public function cert_path_public()
    {
        return Arr::path($this->_config, 'cert.public');
    }

    public function cert_path_private()
    {
        return Arr::path($this->_config, 'cert.private');
    }

}

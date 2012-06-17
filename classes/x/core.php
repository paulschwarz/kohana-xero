<?php
/**
 * @package
 * @author      Paul Schwarz <paulsschwarz@gmail.com>
 * @copyright   2012 Paul Schwarz
 * Date         16/06/12 20:53
 */
class X_Core {

    public static function factory(X_Config $config, $format = 'json')
    {
        return new X_API($config->consumer_key(), $config->consumer_secret(), $config->cert_path_public(),
            $config->cert_path_private(), $format);
    }

}

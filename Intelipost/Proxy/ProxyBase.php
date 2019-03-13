<?php

namespace Intelipost\Proxy;

/**
 * @author Leonardo Volpatto <leovolpatto@gmail.com>
 */
abstract class ProxyBase {
    
    /**
     * @var \Intelipost\Utils\CurlWrapper
     */
    protected $_curl;
    /**
     * @var string
     */
    protected $_baseURL;
    
    protected function InitializeDefaultCurl()
    {
        $config = \Intelipost\IntelipostConfigurations::Instance()->config;
        $this->_curl = new \Intelipost\Utils\CurlWrapper('');
        $this->_curl->SetHttpHeaders("Accept: application/json");
        $this->_curl->SetHttpHeaders("Content-Type: application/json");
        $this->_curl->SetHttpHeaders("api_key: " . $config->apiKey);
        if ($config->platform) {
            $this->_curl->SetHttpHeaders("platform: " . $config->platform);
        }
        $this->_curl->SetEnconding('gzip');
        $this->_curl->SetReturnTransfer(true);
        $this->_curl->SetIncludeHeader(false);
        $this->_baseURL = $config->url;
    }    
    
}

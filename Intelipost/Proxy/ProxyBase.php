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
        $this->_curl = new \Intelipost\Utils\CurlWrapper('');
        $this->_curl->SetHttpHeaders("Accept: application/json");
        $this->_curl->SetHttpHeaders("Content-Type: application/json");
        $this->_curl->SetHttpHeaders("api_key: " . \Intelipost\IntelipostConfigurations::Instance()->config->apiKey);        
        $this->_curl->SetEnconding('gzip');
        $this->_curl->SetReturnTransfer(true);
        $this->_curl->SetIncludeHeader(false);
        $this->_baseURL = \Intelipost\IntelipostConfigurations::Instance()->config->url;        
    }    
    
}

<?php

namespace Intelipost;

/**
 * @author Leonardo Volpatto <leovolpatto@gmail.com>
 */
final class IntelipostConfigurations {
    
    /**
     * @var IntelipostConfigurations
     */
    private static $confs;
    
    /**
    * @return IntelipostConfigurations
    */
    public static function Instance($apiKey = null, $platform = null)
    {
        if(self::$confs == null)
            self::$confs = new IntelipostConfigurations($apiKey, $platform);
        
        return self::$confs;
    }
    
    /**
     * @var IntelipostConfig
     */
    public $config;
    
    public function __construct($apiKey = null, $platform = null) {
        
        $this->config = new IntelipostConfig();
        $this->LoadConfigs($apiKey, $platform);
        
    }
    
    private function LoadConfigs($apiKey, $platform)
    {        
        $this->config->url = "https://api.intelipost.com.br/api/v1";
        // A propriedade "apiKey" Deve ser configurada com a chave de acesso da conta intelipost
        // A chave de acesso pode ser encontrada neste link - https://secure.intelipost.com.br/client-information/
        $this->config->apiKey = $apiKey;    
        $this->config->platform = $platform ?: 'Intelipost-PHP-SDK';
    }  
}

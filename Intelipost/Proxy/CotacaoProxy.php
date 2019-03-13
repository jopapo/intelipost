<?php

namespace Intelipost\Proxy;

use Intelipost\Response;
use Intelipost\IntelipostModel;
use Intelipost;
use Intelipost\Proxy\Arguments\CalcularDataDeEntregaArgs;

/**
 * @author Leonardo Volpatto <leovolpatto@gmail.com>
 */
final class CotacaoProxy extends ProxyBase implements ICotacao {
    
    /**
     * @return \Intelipost\Response\IntelipostMetodosDeEnvioResponse
     */
    public function ConsultarMetodosDeEnvio() {
        $this->InitializeDefaultCurl();        
        
        $this->_curl->SetCustomRequest("GET");        
        $this->_curl->CreateCurl($this->_baseURL . "/info");
        
        return new Response\IntelipostMetodosDeEnvioResponse($this->_curl->GetResult());        
    }

    /**
     * @param int $idCotacaoIntelipost
     * @return \Intelipost\Response\IntelipostCotacaoSemVolumeResponse
     */
    public function ConsultarUmaCotacao($idCotacaoIntelipost) {
        $this->InitializeDefaultCurl();
        
        $this->_curl->SetCustomRequest("GET");        
        $this->_curl->CreateCurl($this->_baseURL . "/quote/$idCotacaoIntelipost");
        
        return new Response\IntelipostCotacaoSemVolumeResponse($this->_curl->GetResult());          
    }

    /**
     * @param \Intelipost\IntelipostModel\quote_by_product $req
     * @return \Intelipost\Response\IntelipostCotacaoSemVolumeResponse
     * @throws \Intelipost\IntelipostCotacaoException
     */
    public function CriarCotacaoPorProduto(IntelipostModel\quote_by_product $req) {
        $json = json_encode($req);
                
        if(json_last_error() > 0)
            throw new \Intelipost\IntelipostCotacaoException("json encode error", $req);

        $this->InitializeDefaultCurl();
        $this->_curl->SetCustomRequest("POST");   
        $this->_curl->SetPost($json);
        $this->_curl->CreateCurl($this->_baseURL . "/quote_by_product");
        $res = $this->_curl->GetResult();
        
        return new Response\IntelipostCotacaoSemVolumeResponse($res);        
    }

    /**
     * @param Intelipost\IntelipostModel\quote $req
     * @return \Intelipost\Response\IntelipostCotacaoSemVolumeResponse
     * @throws \Intelipost\IntelipostCotacaoException
     */
    public function CriarCotacaoPorVolume(Intelipost\IntelipostModel\quote $req) {
    	$json = json_encode($req);
    	
    	if(json_last_error() > 0)
    		throw new \Intelipost\IntelipostCotacaoException("json encode error", $req);
    	
    	$this->InitializeDefaultCurl();
    	$this->_curl->SetCustomRequest("POST");
    	$this->_curl->SetPost($json);
    	$this->_curl->CreateCurl($this->_baseURL . "/quote");
    	$res = $this->_curl->GetResult();
    	
    	return new Response\IntelipostCotacaoSemVolumeResponse($res);    
    }
    
    /**
     * @param CalcularDataDeEntregaArgs $args
     * @return \Intelipost\Response\IntelipostCalcularDataEntregaResponse
     */
    public function CalcularDataDeEntrega(CalcularDataDeEntregaArgs $args)
    {        
        $this->InitializeDefaultCurl();        
        $this->_curl->SetCustomRequest("GET");
        
        $url = $this->_baseURL . "/quote/business_days/{$args->cep_origem}/{$args->cep_destino}/{$args->dias_uteis}";
        if(strlen($args->date) > 0)
        {
            $url .= "?date={$args->date}";
        }
        
        $this->_curl->CreateCurl($url);
        
        return new Response\IntelipostCalcularDataEntregaResponse($this->_curl->GetResult());
    }
    
    /**
     * @param CalcularDataDeEntregaArgs $args
     * @return \Intelipost\Response\IntelipostCalcularDataEntregaResponse
     */
    public function CotacaoContingencia($cepDestino, $peso, $valorNotaFiscal)
    {   
    	return new Response\IntelipostCotacaoContingenciaResponse($cepDestino, $peso, $valorNotaFiscal);
    }

}

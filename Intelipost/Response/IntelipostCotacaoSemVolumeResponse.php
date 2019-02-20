<?php

namespace Intelipost\Response;

/**
 * @author Leonardo Volpatto <leovolpatto@gmail.com>
 */
final class IntelipostCotacaoSemVolumeResponse extends IntelipostResponseBase {
    
    /**
     * @var \integracao\Logistica\IntegracaoIntelipost\IntelipostModel\quote
     */
    private $quote;
    
    private function CreateTypedResponse()
    {
        $q = new \Intelipost\IntelipostModel\quote();
        $parser = new \Intelipost\Utils\JSONParser();
        $this->quote = $parser->parseFromStdClass($q, $this->resultObj);
        
        /*
        $q->client_id = $this->resultObj->client_id;
        $q->created = $this->resultObj->created;
        $q->created_iso = $this->resultObj->created_iso;        
        $q->id = $this->resultObj->id;
        $q->origin_zip_code = $this->resultObj->origin_zip_code;
        $q->destination_zip_code = $this->resultObj->destination_zip_code;
        
        $q->additional_information = new \Intelipost\IntelipostModel\additional_information();
        $q->additional_information->delivery_method_id = $this->resultObj->additional_information->delivery_method_id;
        $q->additional_information->extra_cost_absolute = $this->resultObj->additional_information->extra_cost_absolute;
        $q->additional_information->free_shipping = $this->resultObj->additional_information->free_shipping;
        $q->additional_information->lead_time_business_days = $this->resultObj->additional_information->lead_time_business_days;
        
        $q->delivery_options = array();
        $opts = $this->resultObj->delivery_options;
        foreach($opts as $op)
        {
            $do = new \Intelipost\IntelipostModel\delivery_option();
            $do->delivery_estimate_business_days = $op->delivery_estimate_business_days;
            $do->delivery_method_id = $op->delivery_method_id;
            $do->delivery_method_name = $op->delivery_method_name;
            $do->delivery_method_type = $op->delivery_method_type;
            $do->delivery_note = $op->delivery_note;
            $do->description = $op->description;
            $do->final_shipping_cost = $op->final_shipping_cost;
            $do->logistic_provider_name = $op->logistic_provider_name;
            $do->provider_shipping_cost = $op->provider_shipping_cost;
            array_push($q->delivery_options, $do);
        }
        
        $q->volumes = array();
        $vls = $this->resultObj->volumes;
        foreach($vls as $v)
        {
            $vo = new \Intelipost\IntelipostModel\volume();
            $vo->cost_of_goods = $v->cost_of_goods;
            $vo->description = $v->description;
            $vo->height = $v->height;
            $vo->length = $v->length;
            $vo->volume_type = $v->volume_type;
            $vo->weight = $v->weight;
            $vo->width = $v->width;
            array_push($q->volumes, $vo);
        }
        $this->quote = $q;      */
    }
    
    protected function ProcessResponse() {
        parent::ProcessResponse();
        if ($this->resultObj) {
            $this->CreateTypedResponse();
        }
    }
    
    /**
     * @return \Intelipost\IntelipostModel\quote
     */
    public function GetResult() {
        
        return $this->quote;

    }
    
}

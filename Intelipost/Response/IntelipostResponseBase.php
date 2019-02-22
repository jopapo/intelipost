<?php

namespace Intelipost\Response;

/**
 * @author Leonardo Volpatto <leovolpatto@gmail.com>
 */
abstract class IntelipostResponseBase {

    protected $apiResult;
    protected $resultObj;
    
    /**
     * @var boolean
     */
    public $isSuccess = false;
    /**
     * @var string
     */
    public $message = '';

    public function __construct($apiResult) {
        $this->apiResult = $apiResult;
        $this->ProcessResponse();
    }
    
    protected function ProcessResponse() {
        $res = null;
        $obj = null;
        if (is_object($this->apiResult)) {
            $obj = $this->apiResult;
        } else if (is_array($this->apiResult)) {
            $obj = (object) $this->apiResult;
        } else {
            try {
                $res = gzdecode($this->apiResult);
            } catch (\Exception $ex) {}
            if (! $res) $res = $this->apiResult;
            $obj = json_decode($res);
            if (json_last_error()) {
                throw new IntelipostResponseException('A resposta não pode ser processada: ' . json_last_error_msg(), $this->apiResult);                
            }
        }
        $this->HandleResponseStatus($obj);
        if ($this->isSuccess)
            $this->resultObj = $obj->content;
    }
    
    /**
     * @param \stdClass $obj
     * @throws IntelipostResponseException
     */
    protected function HandleResponseStatus($obj)
    {
        if($obj == null)
            throw new IntelipostResponseException('A resposta não pode ser tratada', $this->apiResult);
        
        if(strtoupper($obj->status) == 'ERROR')
            $this->isSuccess = false;
        else if (in_array(strtoupper($obj->status), ['OK', 'WARNING']))
            $this->isSuccess = true;
        else
            throw new IntelipostResponseException('O status da resposta não é reconhecido: ' . $obj->status, $this->apiResult);

        foreach ($obj->messages as $msg)
            $this->message .= " $msg->type - $msg->text - $msg->key ";
    }


    public function GetResult()
    {
        return $this->resultObj;
    }
    
}

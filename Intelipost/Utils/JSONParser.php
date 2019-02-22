<?php

namespace Intelipost\Utils;

/**
 * Classe JSONParser
 * Objeto utilitário usado para fazer o parse de um json para um determinado 
 * modelo de resposta no sistema.
 * Deve-se "decorar" o objeto de destino com os atributos corretos para que
 * a deserialização funcione de acordo.
 */
final class JSONParser {

    /**
     * Atributo "@arrayOf"
     * Usado para indicar que uma propriedade é um array de um determinado tipo
     * Deve-se informar o namespace completo para criação do objeto
     */
    const arrayOf = "arrayOf";

    /**
     * Atributo "@objectType"
     * Usado para indicar que uma propriedade é um objeto do tipo indicado
     * Deve-se informar o namespace completo para criação do objeto
     */
    const objectType = "objectType";

    /**
     * Atributo "@propertyFrom"
     * Usado para indicar que uma propriedade deve obter seu valor a partir
     * de outra no objeto resultado do JSON.
     */
    const propertyFrom = "propertyFrom";

    /**
     * Faz o parse do json para um objeto de destino
     * @param type $json String JSON serializada com as propriedades do objeto destino
     * @param type $obj Instância do objeto que receberá os dados do JSON
     */
    public static function parse($json, $obj) {
        $x = json_decode($json);
        
        $jsonError = json_last_error();
        if ($jsonError > 0) {
            $error = JSONParser::json_error_msg($jsonError);
            throw new \Exception("Ocorreu um erro ao decodificar o JSON. Erro: $error");
        }
        
        return self::parseFromStdClass($x, $obj);
    }

    /**
     * Faz a conversão de um stdclass para um objeto de destino
     * @param stdclass $x StdClass com as propriedades do objeto destino
     * @param type $obj Instância do objeto que receberá os dados do JSON
     */
    public static function parseFromStdClass($target, $obj) {
        $obj = JSONParser::parseObject($target, $obj);
        return $obj;
    }

    /**
     * Função recursiva para deserialização genérica do objeto
     */
    private static function parseObject($source, $dest) {
        $reflector = new \ReflectionClass(get_class($dest));
        $props = $reflector->getProperties();

        foreach ($props as $prop) {
            if ($prop->isPrivate()) {
                continue;
            }
            
            $propName = $prop->getName();
            $comment = $prop->getDocComment();
            
            $propertyFrom = JSONParser::GetAttribute($comment, JSONParser::propertyFrom);
            if ($propertyFrom === false) {
                if (!is_array($source)) {
                    $val = $source->{$propName};
                } else {
                    $val = null;
                }
            } else {
                $val = $source->{$propertyFrom};
            }

            if (is_array($val) || is_array($source)) {
                $dest = JSONParser::parseObjectArray((isset($val) ? $val : $source), $dest, $propName, $comment);
            } else if (is_object($val)) {
                $dest = JSONParser::parseObjectObject($val, $dest, $propName, $comment);
            } else {
                $dest->{$propName} = $val;
            }
        }

        return $dest;
    }

    /**
     * Faz o parsing de um objeto JSON para um objeto tipado do sistema
     */
    private static function parseObjectObject($obj, $dest, $propName, $comment) {
        $typeObj = JSONParser::GetAttribute($comment, JSONParser::objectType);
        $newObj = JSONParser::parseObject($obj, new $typeObj);

        if (isset($newObj)) {
            $dest->{$propName} = $newObj;
        }

        return $dest;
    }

    /**
     * Faz o parsing de um array JSON para um objeto tipado do sistema
     */
    private static function parseObjectArray($arr, $dest, $propName, $comment) {
        $arrayOf = JSONParser::GetAttribute($comment, JSONParser::arrayOf);

        if ($arrayOf === false) {
            $dest->{$propName} = $arr;
        } else {
            $dest->{$propName} = array();
            foreach ($arr as $item) {
                $newObj = JSONParser::parseObject($item, new $arrayOf);
                if (isset($newObj)) {
                    array_push($dest->{$propName}, $newObj);
                }
            }
        }

        return $dest;
    }

    /**
     * Busca um determinado atributo
     * @param type $comment Comentário que define o atributo
     * @param type $attributeName Nome do atributo procurado
     * @return type Retorna FALSE se não achar e, retorna o valor do atributo caso ache o mesmo
     */
    private static function GetAttribute($comment, $attributeName) {
        if (strlen($comment) == 0) {
            return false;
        }

        $matches = [];
        preg_match("/@$attributeName .+/", $comment, $matches, PREG_OFFSET_CAPTURE);
        if (count($matches) == 0) {
            return false;
        }

        $exp = explode(' ', $matches[0][0]);
        if (count($exp) >= 2) {
            return trim($exp[1]);
        }

        return false;
    }

    /**
     * Retorna a descrição para o erro ocorrido no parsing do JSON
     * @param type $errorNumber
     * @return string
     */
    private static function json_error_msg($errorNumber) {
        switch ($errorNumber) {
            default:
                return;
            case 1:
                $error = 'Maximum stack depth exceeded';
                break;
            case 2:
                $error = 'Underflow or the modes mismatch';
                break;
            case 3:
                $error = 'Unexpected control character found';
                break;
            case 4:
                $error = 'Syntax error, malformed JSON';
                break;
            case 5:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
        }

        return $error;
    }

}

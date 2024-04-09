<?php

declare(strict_types=1);

namespace Ivanrufino\Logger;

class Logger
{
    private static $instance;
    private $pathFile;
    private $pathFileDefault;
    private $nameFile;
    private $uniqueId = null;
    private $messageFormat;
    private $type;
    private $configuracao;


    /*  private function __construct($pathFile,$nameFile,$messageFormat) */
    private function __construct($configuracao)
    {
        
        $this->pathFileDefault = sprintf("%s/%s", $this->getPathDefault(), "log");
        $this->configuracao = $configuracao;
        $this->uniqueId = uniqid(gmdate("YmdHis"));
        $this->setConfiguracao();
        //$this->setPathFile($pathFile);
        //$this->senameFile($nameFile);
        //$this->messageFormat =$messageFormat;

    }
    private function getPathDefault()
    {
        // Caminho completo do arquivo atual
        $caminhoCompleto = __FILE__;

        // Separando o caminho do arquivo em partes usando a barra como delimitador
        $partesCaminho = explode(DIRECTORY_SEPARATOR, $caminhoCompleto);

        // Encontrando a posição do diretório "vendor"
        $indiceVendor = array_search('vendor', $partesCaminho);

        // Se o diretório "vendor" for encontrado
        if ($indiceVendor !== false) {
            // Removendo todas as partes do caminho do arquivo a partir do diretório "vendor"
            $caminhoRaiz = implode(DIRECTORY_SEPARATOR, array_slice($partesCaminho, 0, $indiceVendor));
           
        } else {
            $caminhoRaiz=  dirname((__DIR__));
            //echo "Diretório 'vendor' não encontrado no caminho do arquivo.";
        }

        return $caminhoRaiz;

    }
    private function setConfiguracao()
    {
        $this->setPathFile();
        $this->setNameFile();
        $this->setMessageFormat();
    }
    private function setPathFile()
    {
        $this->pathFile = $this->pathFileDefault;
        if (!is_null($this->configuracao) && isset($this->configuracao['path'])) {
            $this->pathFile = $this->getPathDefault() . "/" . $this->configuracao['path'];
        }
        
    }
    private function setNameFile()
    {
        $this->nameFile = sprintf("log_%s.log", date("Ymd"));
        if (!is_null($this->configuracao) && isset($this->configuracao['nameFile'])) {
            $this->nameFile = $this->formataNomeArquivo();
            ;
        }
    }
    private function setMessageFormat()
    {

        $this->messageFormat = "[%d[d/m/Y H:i:s]] [%u]] [%t] %m";

        if (!is_null($this->configuracao) && isset($this->configuracao['messageFormat'])) {
            $this->messageFormat = $this->configuracao['messageFormat'];
        }
    }
    public static function start($configuracao = null/* $pathFile = null, $nameFile = null, $messageFormat = null,  */)
    {
        if (!isset(self::$instance)) {
            /*  self::$instance = new Logger($pathFile,$nameFile, $messageFormat); */
            self::$instance = new Logger($configuracao);
        }
        return self::$instance;
    }
   
    public function log($message, $type = "INFO")
    {

        DirectoryHandler::createDirectory($this->pathFile);
        $pathFull = sprintf("%s/%s", $this->pathFile, $this->nameFile);
       
        $this->type = LoggerType::getType($type);
        $messageLog = $this->formataMensagem($message);
        file_put_contents($pathFull, $messageLog . PHP_EOL, FILE_APPEND);

    }
    private function createMessageLog($data)
    {

        $message = sprintf("[%s] [%s] [%s] - %s", date('d/m/Y H:i:s'), $this->uniqueId, $this->type, $data);
        //$message ="[". date('d/m/Y H:i:s') ."] [".$type."] - ".$data;
        return $message;
    }
    public function printToTerminal($message,$type = "INFO")
    {
        $this->type = LoggerType::getType($type);
        echo $this->formataMensagem($message . PHP_EOL);

    }

    private function formataNomeArquivo()
    {
        $padrao = '/%([a-zA-Z])(?:\[(.*?)\])?/';

        // Função de callback para substituir os marcadores
        $substituir = function ($matches) {
            $tipo = $matches[1];
            $argumento = $matches[2] ?? null;

            // Verifica o tipo do marcador e realiza a substituição
            switch ($tipo) {
                case 'd':
                    return date($argumento ?: 'Y-m-d H:i:s');
                case 'u':
                    return $this->uniqueId; // Substitua 'SuaStringEspecifica' pela sua string específica
                case 't':
                    return $this->type;

                // Adicione mais casos conforme necessário
                default:
                    // Se o marcador não for reconhecido, mantém o marcador original
                    return "";
                //return $matches[0];
            }
        };

        // Executa a substituição na string usando a função de callback
        // Executa a substituição na string usando a função de callback
        $nomeArquivo = preg_replace_callback($padrao, $substituir, $this->configuracao['nameFile']);

        // Substitui espaços por underscores
        $nomeArquivo = str_replace(' ', '_', $nomeArquivo);

        return $nomeArquivo;
    }
    private function formataMensagem($message)
    {
        // Verifica se o marcador %m está presente na string de formato , referente a Mensagem do log
        if (strpos($this->messageFormat, '%m') === false) {
            // Se não estiver presente, adiciona o marcador %m à string de formato
            $this->messageFormat .= ' %m';
        }
        // Expressão regular para encontrar marcadores no formato [%letra[argumento]]
        $padrao = '/%([a-zA-Z])(?:\[(.*?)\])?/';

        // Função de callback para substituir os marcadores
        $substituir = function ($matches) use ($message) {
            $tipo = $matches[1];
            $argumento = $matches[2] ?? null;

            // Verifica o tipo do marcador e realiza a substituição
            switch ($tipo) {
                case 'd':
                    return date($argumento ?: 'Y-m-d H:i:s');
                case 'u':
                    return $this->uniqueId; // Substitua 'SuaStringEspecifica' pela sua string específica
                case 't':
                    return $this->type;
                case 'm':

                    return is_array($message)? json_encode($message): $message;
                // Adicione mais casos conforme necessário
                default:
                    // Se o marcador não for reconhecido, mantém o marcador original
                    return "";
                //return $matches[0];
            }
        };

        // Executa a substituição na string usando a função de callback
        return preg_replace_callback($padrao, $substituir, $this->messageFormat);
    }
}

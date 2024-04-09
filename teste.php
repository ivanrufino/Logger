<?php
include "vendor/autoload.php";
use Ivanrufino\Logger\Logger;


$path = '/caminho/do/arquivo.log';
$configuracao=[
    'paths'=>"caminho/dos/meus/arquivos",
    'nameFile'=>"%d[ymd] %u.log",
    'messageFormat'=>"%d[H:i:s] %t %u %m"
    
];
//$logger = Logger::getInstance($path,nameFile:"hoje.log", messageFormat: "[%d[d/m/Y H:i:s]] [%u]] [%t] %m" );
$logger = Logger::getInstance();

// Agora você pode usar $logger para gravar logs
//$logger->log("Mensagem de log aqui.");
$logger->log("Mensagem de log aqui.");
$logger->log("Mensagem de log aqui.",'errOr');
$logger->log("Mensagem de log aqui 1.",1);
$logger->log("Mensagem de log aqui 2.",2);
$logger->log("Mensagem de log aqui 3.",3);
$logger->log("Mensagem de log aqui 4.",4);

$logger->log("Mensagem de log aqui 5.",5);

$logger->log("Mensagem de log aqui 6.",6);
$logger->log("Mensagem de log aqui 7.",7);
$logger->log(["nome"=>"ivan", "idade"=>30],'info');
$logger->log(10,'critical');
$logger->log(10.9,'critical');
$logger->log(false,'warning');
$logger->printToTerminal("Mensagem de log aqui 7 muotas li8nhas aqui.",7);



//$logger->printToTerminal("Mensagem de log aqui.");
/*
espaços no nome do arquivo serar alterados para undescores "_"
ao instancia a classe podera ser passado um array de configuração nao obrigatorio
os elementos do array sao
- path : caminho onde os arquivos vão ficar, se não for informado o padrão é ./logs
- nameFile : Nome dos arquivos que vai ter, se não for informado o padrão é app_%Y%m%d.log
- messageFormat : Formato da mensagem que vai ser gravada no arquivo, se não for informado o padrão é "[%d[d/m/Y H:i:s]] [%u]] [%t] %m %
- messageFormat : Formato da mensagem exemplo "[%d[d/m/Y H:i:s]] [%u]] [%t]"
                   - %d Data atual em formato Y-m-d [Y-m-d H:i:s]. seguindo o padrao do format da função date
                   - %d[format]  : data atual com o formato especificado
                   - %U identificador Unico gerado a cada requisicao do Logger.
                   - %t tipo do log podendo ser INFO, ERROR.  etc...,  se nenhum for enviado sera considerado como INFO

chamada da função será feita da seguinte forma
$logger = Logger::getInstance($configuracao); $configuração é um campo opcional
Logger::log("Mensagem Teste",2); será gerado um arquivo de acordo com as configurações 

Logger::printToTerminal("Mensagem Teste",1); Irá exibir no terminal

os tipos permitidos sao:
INFO = 1
ERROR = 2
WARNING = 3
DEBUG = 4
CRITICAL = 5
ALERT = 6
EMERGENCY = 7
*/

<?php

declare(strict_types=1);

namespace Ivanrufino\Logger;

class DirectoryHandler
{
    public static function createDirectory($path):bool
    {
        //Verificar se é um arquivo ou pasta
        try {
            
            if(!is_dir($path)) {
                if(!mkdir($path,0777,true)){
                    throw new \Exception("Não foi possivel criar o diretório");
                }
                /* self::createDirectory($path); */
            }
            
            return true;
           
        } catch (\Exception $th) {
            echo  "Error ao criar o diretorio: {$th->getMessage()}\n";
            return false;
        }
    }
   /*  public static function createDirectory($path)
    {
        if(!mkdir($path,0777,true)){
            throw new \Exception("Não foi possivel criar o diretório");
        }
    } */




}
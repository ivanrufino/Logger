<?php

declare(strict_types=1);

namespace Ivanrufino\Logger;

class LoggerType
{
    public const INFO = 1;
    public const ERROR = 2;
    public const WARNING = 3;
    public const DEBUG = 4;
    public const CRITICAL = 5;
    public const ALERT = 6;
    public const EMERGENCY = 7;


    public static function getType($type): string
    {
        $type= is_string( $type ) ? strtolower(  $type) : $type ;
        $type_returned = "INFO";
        switch ($type) {
            case self::INFO:
            case 'info':
                $type_returned = 'INFO';
                break;
            case self::ERROR:
            case 'error':
                $type_returned = 'ERROR';
                break;
            case self::WARNING:
            case 'warning':
                $type_returned = 'WARNING';
                break;
            case self::DEBUG:
            case 'debug':
                $type_returned = 'DEBUG';
                break;

            case self::CRITICAL:
            case 'critical':
                $type_returned = 'CRITICAL';
                break;
            case self::ALERT:
            case 'alert':
                $type_returned = 'ALERT';
                break;
            case self::EMERGENCY:
            case 'emeregency':
                $type_returned = 'EMERGENCY';
                break;

            default:
                $type_returned = 'INFO';
                break;
        }
        return $type_returned;
    }
}

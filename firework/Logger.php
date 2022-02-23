<?php

namespace Firework;

/*
 * Class logs the data it gets into file ./logs.
 * Includes
 *  public log method.
 */
class Logger
{
    /*
     * Writes data in logs file.
     */
    /**
     * @param string $logType
     * @param string $logText
     * @param string $fromFile
     * @return void
     */
    public function log(string $logType, string $logText, string $inFile)
    {
        file_put_contents(__DIR__ . '/../logs', '['
            . date('d.m.Y, H:i:s') . ']'
            . $logType . ': '
            . $logText . ' in file '
            . $inFile
            . PHP_EOL);
    }
}
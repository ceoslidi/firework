<?php

namespace Firework;

use Config\Config;

class File
{
    private Config $config;

    private array $files;

    public function __construct()
    {
        $this->config = new Config();
        $this->files = $_FILES;
    }

    public function upload(string $formName)
    {
        $settings = $this->config->getUploadsSettings();
        $targetDir = $settings['dir'];
        $mime = $settings['onlyImage'];
        $maxSize = $settings['maxSize'];
        $tempname = $this->files[$formName]["tmp_name"];
        $filename =str_replace(' ', '', __DIR__ . '/../' . $targetDir . time() . '-' . basename($this->files[$formName]["name"]));
        $size = $this->files[$formName]["size"];

        $isOk = true;

        if (boolval($mime))
        {
            $check = getimagesize($tempname);

            if ($check ===  false) {
                $isOk = false;
            }
        }

        if ($size > intval($maxSize))
        {
            $isOk = false;
        }

        if ($isOk)
        {
            move_uploaded_file($tempname, $filename);
        }
    }
}
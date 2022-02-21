<?php

namespace Firework;

use Config\Config;

/*
 Class controls the file upload settings.
 Includes:
  constructor,
  public upload method.
 */
class File
{
    private Config $config;

    private array $files;

    public function __construct()
    {
        $this->config = new Config();
        $this->files = $_FILES;
    }

    /*
     Controls file upload settings.
     */
    /**
     * @param string $formName
     * @return void
     */
    public function upload(string $formName)
    {
        $settings = $this->config->getUploadsSettings();
        $targetDir = $settings['dir'];
        $mime = $settings['onlyImage'];
        $maxSize = $settings['maxSize'];
        $tempName = $this->files[$formName]["tmp_name"];

        /** @var string $fileName */
        $fileName = str_replace(' ', '', __DIR__ . '/../' . $targetDir . time()
             . '-' . basename($this->files[$formName]["name"]));
        $size = $this->files[$formName]["size"];

        $isOK = true;

        if (boolval($mime))
        {
            $check = getimagesize($tempName);

            if ($check ===  false) {
                $isOK = false;
            }
        }

        if ($size > intval($maxSize))
        {
            $isOK = false;
        }

        if ($isOK)
        {
            move_uploaded_file($tempName, $fileName);
        }
    }
}
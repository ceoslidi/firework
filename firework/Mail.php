<?php

namespace Firework;

use Config\Config;

use JetBrains\PhpStorm\Pure;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private Config $config;
    private PHPMailer $phpmailer;

    public function __construct()
    {
        $this->config = new Config();
        $this->phpmailer = new PHPMailer(true);
    }

    /**
     * @param string $recipient
     * @param string $subject
     * @param string $body
     * @return bool
     * @throws Exception
     */
    public function mail(string $recipient, string $subject, string $body): bool
    {
        $settings = $this->config->getMailSettings();

        $this->phpmailer->SMTPDebug = 0;
        $this->phpmailer->isSMTP();
        $this->phpmailer->SMTPSecure = 'tls';
        $this->phpmailer->SMTPAuth = true;
        $this->phpmailer->Host = $settings['host'];
        $this->phpmailer->Username = $settings['user'];
        $this->phpmailer->Password = $settings['pass'];
        $this->phpmailer->Port = $settings['port'];
        $this->phpmailer->isHTML(true);

        $this->phpmailer->From = $settings['user'];
        $this->phpmailer->FromName = $settings['from'];
        $this->phpmailer->addAddress($recipient);
        $this->phpmailer->Subject = $subject;
        $this->phpmailer->Body = $body;

        $status = $this->phpmailer->send();

        if ($status) return true;
        else return false;
    }
}
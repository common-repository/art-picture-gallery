<?php
/**
 * ArtPicture Plugin PHP Class
 * http://art-pictureDesign.de/WP-ArtTheme-Galerie
 * Copyright 2017, Jens Wiecker
 * https://art-picturedesign.de
 *
 */
namespace APG\ArtPictureGallery;
require 'mail/vendor/autoload.php';
require_once('ApgCore.php');
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use APG\ArtPictureGallery\Core as Core;

date_default_timezone_set("Europe/Berlin");
class MailHandler extends Core
{
    public function __construct($opt = null, $return = null){
        $this->opt = array("method" => null, "data" => null);
        if ($opt)        {
            $this->opt = $opt + $this->opt;
        }
        $this->return = $this->mail_handel();
    }
    private function mail_handel()  {
        switch ($this->opt['method'])
        {
            case 'smtp_check':
                $entry = $this->smpt_check();
                $return = array("status" => $entry['status'], "message" => $entry['message']);
                break;
        }
        $this->return = $return;
        return $this->return;
    }
    private function smpt_check() {
        $status = false;
        $smtp = new SMTP;
        try
        {
            //Connect to an SMTP server
            if (!$smtp->connect($this->opt['data']['host'], $this->opt['data']['port'])){
                throw new Exception('Connect failed');
            }
            //Say hello
            if (!$smtp->hello(gethostname()))
            {
                throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
            }
            //Get the list of ESMTP services the server offers
            $e = $smtp->getServerExtList();
            //If server can do TLS encryption, use it
            if (is_array($e) && array_key_exists('STARTTLS', $e))
            {
                $tlsok = $smtp->startTLS();
                if (!$tlsok)
                {
                    throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
                }
                //Repeat EHLO after STARTTLS
                if (!$smtp->hello(gethostname()))
                {
                    throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
                }
                //Get new capabilities list, which will usually now include AUTH if it didn't before
                $e = $smtp->getServerExtList();
            }
            //If server supports authentication, do it (even if no encryption)
            if (is_array($e) && array_key_exists('AUTH', $e))
            {
                if ($smtp->authenticate($this->opt['data']['bn'], $this->opt['data']['pw']))
                {
                    $msg .= "Connected ok!";
                    $status = true;
                } else
                {
                    throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
                }
            }
        }
        catch (exception $e)
        {
            $msg .= 'SMTP error: ' . $e->getMessage() . "\n";
            //$msg .= $e->getMessage();
        }
        //Whatever happened, close the connection.
        $smtp->quit(true);
        return array("status" => $status, "message" => $msg);
    }
}
?>
<?php

/**
 * Rsa
 */
class Rsa
{
    public $privateKey = '';
    public $publicKey = '';

    public function __construct()
    {
        $conf = ['config' => 'D:\phpStudy\PHPTutorial\php\php-5.6.27-nts\extras\openssl.cnf'];
        $resource = openssl_pkey_new($conf) or die('<br>err：'. openssl_error_string());
        openssl_pkey_export($resource, $this->privateKey, null, $conf);
        $detail = openssl_pkey_get_details($resource);
        $this->publicKey = $detail['key'];
    }

    public function publicEncrypt($data)
    {
        openssl_public_encrypt($data, $crypted, $this->publicKey);
        return $crypted;
    }

    public function publicDecrypt($data)
    {
        openssl_public_decrypt($data, $decrypted, $this->publicKey);
        return $decrypted;
    }

    public function privateEncrypt($data)
    {
        openssl_private_encrypt($data, $crypted, $this->privateKey);
        return $crypted;
    }

    public function privateDecrypt($data)
    {
        openssl_private_decrypt($data, $decrypted, $this->privateKey);
        return $decrypted;
    }
}


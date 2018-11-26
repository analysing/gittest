<?php

/**
 * Rsa
 */
class Rsa
{
    protected $privateKey = '';
    protected $publicKey = '';

    function __construct()
    {
        $resource = openssl_pkey_new();
        openssl_pkey_export($resource, $this->privateKey);
        $detail = openssl_pkey_get_details($resource);
        $this->publicKey = $detail['key'];
    }
}
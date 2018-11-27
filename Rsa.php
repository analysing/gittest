<?php

/**
 * Rsa
 */
class Rsa
{
    public $privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQCz+9OdWejOpGtxlNld9F4dFKoqRKCiw+OaPXMGknERDO2sSRXM
6ArIVtep4koexJSVVMKbAj+e5qFmRtDfg41ZySCmMTMJWlSqlzz2cWBc9Dn1jl8W
K6K89kkhoSKG5/kW5ifEuAC3M15YVp3or7lsjSfCTAjDxSU7bIu0a4Q7oQIDAQAB
AoGAT8H+yrH3Gut9uX2OvbX2pshriAOVc8t+5vDoMjde54FlKX3RrVX+wTzKoTvo
QK44cdx3yJ08eDwXte0XzpTLZAj/NGRHogwPNAP1naxPduXlj/INzS+OKMgeTl0P
iIPUmQeYBC8oQappMjUtCGx7amduDOVh9x4PMYIUAOopwskCQQDvWMJ4TMlEuDTC
cylWobnNn8VaVqPuVh0Hc4FbU7jHYNOX/9JDzGfmM2gO/GbRCKnglhj4K/w65prh
Z7mQkHzHAkEAwIGxlo6BNgVkJ/NXARDeceT5gHozCvjzlUiwwxE8xswWIu/DbOJX
omZBwr7PsP7wqZFk5PJfEQnCeChg6WuMVwJADiT/sR5QkqgULh2iJsV99oHnptQR
8gbSxlr0HRKQi+/T8Vqj8W/GABuvnZsa9GV/rI8SQLBQwqZYJtP7amivhwJAOUmf
Pq2z2A6sqpLo7mFFwWEhutEixX4mhuN17ub/Ti3H3Ke7YXjOGX8SzNCZ4BNOLTge
bV+PWPOtkrJ5fJ1LywJAYv9jbdmemoUBaslUiO8nN4L5la+hKod8fLH5NscIap8R
BdtT1e5wwZ4LcCMXL9LgiA/bdicvqutyVtQignu2mg==
-----END RSA PRIVATE KEY-----'; // 私钥
    public $publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCz+9OdWejOpGtxlNld9F4dFKoq
RKCiw+OaPXMGknERDO2sSRXM6ArIVtep4koexJSVVMKbAj+e5qFmRtDfg41ZySCm
MTMJWlSqlzz2cWBc9Dn1jl8WK6K89kkhoSKG5/kW5ifEuAC3M15YVp3or7lsjSfC
TAjDxSU7bIu0a4Q7oQIDAQAB
-----END PUBLIC KEY-----'; // 公钥

    public function __construct()
    {
        if (!$this->privateKey || !$this->publicKey) {
            $conf = ['config' => 'D:\phpStudy\PHPTutorial\php\php-5.6.27-nts\extras\openssl.cnf'];
            $resource = openssl_pkey_new($conf) or die('<br>err：'. openssl_error_string());
            openssl_pkey_export($resource, $this->privateKey, null, $conf); // 设置私钥
            // 设置公钥
            $detail = openssl_pkey_get_details($resource);
            $this->publicKey = $detail['key'];
        }
    }

    /**
     * 公钥加密，需要使用私钥解密
     * @param  string $data 要加密的数据
     * @return string       加密后的数据
     */
    public function publicEncrypt($data)
    {
        openssl_public_encrypt($data, $crypted, $this->publicKey);
        return $crypted;
    }

    /**
     * 公钥解密
     * @param  string $data 使用私钥加密的数据
     * @return string       解密后的数据
     */
    public function publicDecrypt($data)
    {
        openssl_public_decrypt($data, $decrypted, $this->publicKey);
        return $decrypted;
    }

    /**
     * 私钥加密，需要使用公钥解密
     * @param  string $data 要加密的数据
     * @return string       加密后的数据
     */
    public function privateEncrypt($data)
    {
        openssl_private_encrypt($data, $crypted, $this->privateKey);
        return $crypted;
    }

    /**
     * 私钥解密
     * @param  string $data 使用公钥加密的数据
     * @return string       解密后的数据
     */
    public function privateDecrypt($data)
    {
        openssl_private_decrypt($data, $decrypted, $this->privateKey);
        return $decrypted;
    }
}

/*$r = new Rsa();
$res = $r->publicEncrypt(base64_encode('hello ivy'));
// echo '<br>privateKey:', $r->privateKey;
// echo '<br>publicKey:', $r->publicKey;
echo '<br>decrypt:', base64_decode($r->privateDecrypt($res));*/

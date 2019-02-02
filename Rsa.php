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

    public function opensslEncrypt($data, $key)
    {
        return openssl_encrypt($data, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
    }

    public function opensslDecrypt($data, $key)
    {
        return openssl_decrypt($data, 'AES-128-ECB', $key, OPENSSL_RAW_DATA); // openssl_get_cipher_methods()获取可用的加密算法
    }
}

/*$r = new Rsa();
$res = $r->publicEncrypt(base64_encode('hello ivy'));
// echo '<br>privateKey:', $r->privateKey;
// echo '<br>publicKey:', $r->publicKey;
echo '<br>decrypt:', base64_decode($r->privateDecrypt($res));*/

$r = new Rsa();
$datas = 'dlVLwVcCPxy+Mkp5P02/4ymudPLbsrhkvq7OAacDaL+5pPrmcp5p+2SAVp0rGpXLxBwdDVTKOsolYBmqE3ZnsP0/viGWUqaY6q1O6epusL5o1rqWIP7ysjWXebtRixBYwgmQl2NrfgELEFySKwDUHbu0XZbd/8FpkK/heq0m0Dc='; // 0123456789abcdef
$datas = 'O04Og6Y65CcM0njaPkxfrlYgCKP+hayd7CXRjZ4J6UpK4tZwnRjlxOZzIn+Sy9nJS7E4pPQQrCeUbAU18exIw8NwhLh8RgU2hHcKk7l+0bag3hVP6OX6BcwHDV2+MS9zPjaepkTBOLWrkaAsaEAcaJk5GB6Enpf6wTc5b2Na4nA='; // 0123456789abcdef
// $datas = '9aBSn6Z7+h82X4qI/1jRSvxSZupgXRJhPjtSwQFhJZSDM8RZC5VEHsF4s9xjQcx7WXhuD7pWkIeC6LfTtbXQ+3cboe+UEaTqyS20L6vgcWXPnERDt2hS7he/NWalGq6U';
// $datas = 'IueNFWirtBAWeXUKsWNyKOai3C3uDkpT2Zl50vXPmuAPfLGkOmUcsPYiG6cjEXc0CmmjMgUUbBUBcpBOFv+/xgj/cDDRFJr1OEmZYFAEcY7ld0LTC3q3JwqdKfAZqI+O';
// $datas = 'IueNFWirtBAWeXUKsWNyKLyYAVX0HL+oqWgG4qnhr4e/mQv93G81hIIcFt7KKqsO';
echo mb_strlen(base64_decode($datas));
$crypto = '';
foreach (str_split(base64_decode($datas), 128) as $chunk) {
    $res = $r->privateDecrypt($chunk);
    $crypto .= $res;
}
var_dump(json_decode($crypto, true));

$res = openssl_decrypt(base64_decode($datas), "AES-128-ECB", '0123456789abcdef', OPENSSL_RAW_DATA);
var_dump(json_decode($res, true));

// print_r(openssl_get_cipher_methods()); // 列出可用的加密方法

/*$key = 'ivyivy1234!';
$encrypt = base64_encode($r->opensslEncrypt('ivy1234', $key));
echo $r->opensslDecrypt(base64_decode($encrypt), $key);*/
$encrypt = 'lV2/GS2YPa+qNbekmUOY2iF3Bsiea/kYpZN/mxu+22nB0onImNFf7M0K6U/T9FQE';
$encrypt = 'fiHU6oVrtGuJ7WWzdtdE4mi+Tk59YJZebnep9AmpgHhiZF7cYLH/xd+UzIn5k4BJ5UcDo2n54GaiFWNZcw/EmqjKiE6g9NNS6CrkD3lZS3BU0NOSpJ8vj+fk0A1+cIsK0QGdO+YtSU2BBw3gS1UL3egtMO94+5YNM6I7Hv5vOTJsD1s8V4rw81DFajouG13gr1CvdR7nsTQBNkrgpqyN+sq+G6/XNRxZ7U7CRyLt3cMrIzmIHVhcL7qLFUpjoZXCigGBJP2CFWaXCBlfM0x4bon0wyg6S8kGyccdp2p2KNmitkDdWBFlzbT6HuRrEU5HXpr86EEH6Y9mQ7lCqaijADOxHDS/Ie2wPQ59KjypJjXgbBvFsMniIBTaCGDoYNUGz+fP0UIbxkwrpejrZ2iOpm4SFs6E2cWXbCAlnup7EW8VkyidnBQvv/G6ka0yEgXcssdcbuxovspBqMytCiNm40KiR6NwUMRBiQfO0l/Dqgf2MNnbqpdvl1ri0elEJyPuMWvui6FzzkNHvl79ODTBz3r3dVoLCGCXBP86eQH7HstlIaHjJI2ViuvMUt+oZqEWLCM2mSL7WUUqG5hT88fpfo2wNKqkgvG0auPo6CairDRF0/fvFzD97O2Aa6/BKy7qBIOsT4AdMsfbmGJFlflTuNEpB+5kqxwvV16QrLFjA+aSnBu9DBIENt+n1H314Tue1yAPBLRqK0Xj7sGaXI36n5jv92Mps4uAlC7ODHTZTj8AayrXAQy604I2lt3kBZO0nb77dOf7w1Ryg47FeVGwAQO/clpsXVTLMoIgBw7cxVhg3NctqOw9WiSJSsKHWhTZKecVc1U4i/3X//EvFU+2ibB5OoHcQlX0PQskCN/9OlAXxGXPc/vKMtuxtflC0ySlRqFD9yT57JEqOwc7mYJs7AcQ5CJzzoVhuDgrxf7JsdtbzwdXaFdp07hlCOa+91EwalgUPRpBrE59em4Icdq7Ooko6ht3WYiFvLT+nocRrTRePh1ziRmwh64pbo32r6YMjrwfXlFN4Ek+gYU2jpUlSA==';
echo $r->opensslDecrypt(base64_decode($encrypt), '0123456789abcdef');
$data = [
    'username' => 'fairy1',
    'password' => 'a123456',
    'str' => 1,
    'is_wap' => 1,
    'captcha_id' => '',
    'verifyCode' => '',
];
$data1 = [
    'user_id' => 957242,
    'platform' => 4,
];
// echo '<br>', base64_encode($r->opensslEncrypt(json_encode($data), '0123456789abcdef'));
// {"op":"buy","lotteryId":"1","curRebate":0.0050000000000000044,"modes":0.5,"xgame":1,"multiple":1,"token":"1545805177095f8i7300g64fri5sr2bls4z5syabdvzrq","issue":"20181226-050","codes":"1215:牛5_牛6"}
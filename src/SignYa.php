<?php

namespace Yiyan\TestCom;

class SignYa
{
    /**
     * rsa私钥签名
     *
     * @param $content //待签名字符串
     * @param $privateKey //私钥
     * @param $algorithm //OPENSSL_ALGO_SHA1 OPENSSL_ALGO_SHA256。。。
     * @return false|string
     */
    public static function rsaSign($content, $privateKey, $algorithm = OPENSSL_ALGO_SHA1, $encrypt_method = 'base64'){

        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($privateKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        $key = openssl_get_privatekey($privateKey);

        if(!$key) return false;

        openssl_sign($content, $signature, $key, $algorithm);

        openssl_free_key($key);

        $sign = CryptYa::encrypt($signature, $encrypt_method);

        return $sign;
    }

    /**
     * rsa 公钥验签
     *
     * @param $sign 签名
     * @param $toSign 待签名字符串
     * @param $publicKey 公钥
     * @param $encrypt_method 解密方式
     * @param $signature_alg 算法
     * @return bool
     */
    public static function rsaCheckSign($sign,$toSign,$publicKey,$signature_alg=OPENSSL_ALGO_SHA1,$encrypt_method='base64'){
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($publicKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";

        $publicKey = openssl_get_publickey($publicKey);

        $result=openssl_verify($toSign, CryptYa::decrypt($sign,$encrypt_method), $publicKey, $signature_alg);

        return $result == 1 ? true : false;
    }

    /**
     * 自定义ascii排序
     *
     * @param $params
     * @param $flags
     * @return false|string
     */
    public static function _ascii($params = array(), $flags = SORT_REGULAR)
    {
        if (!empty($params)) {

            $p =  ksort($params, $flags);

            if ($p) {

                $str = '';

                foreach ($params as $k => $val) {

                    if ($val != null)
                    {
                        $str .= $k .'=' . $val . '&';
                    }
                }

                $strs = rtrim($str, '&');

                return $strs;
            }
        }

        return false;
    }


}
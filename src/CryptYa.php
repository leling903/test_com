<?php

namespace Yiyan\TestCom;

class CryptYa
{
    /**
     * 加密
     *
     * @param $content
     * @param $encrypt_method
     * @return string
     */
    public static function encrypt($content, $encrypt_method)
    {
        $cryptText = '';

        switch ($encrypt_method) {
            case 'base64':
                $cryptText = base64_encode($content);
                break;
            case 'hex':
                $cryptText = bin2hex($content);
                break;

        }

        return $cryptText;
    }

    /**
     * 解密
     *
     * @param $cryptText
     * @param $encrypt_method
     * @return false|string
     */
    public static function decrypt($cryptText, $encrypt_method)
    {
        $content = '';

        switch ($encrypt_method) {
            case 'base64':
                $content = base64_decode($cryptText);
                break;
            case 'hex':
                $content = hex2bin($cryptText);
                break;

        }

        return $content;
    }

    /**
     * aes Ebc加密
     *
     * @param $data
     * @param $password
     * @param $option
     * @param $code
     * @param $method
     * @return string
     */
    function aesEbcEncrypt($data,$password, $option = OPENSSL_RAW_DATA,$code = 'base64',$method='AES-128-ECB')
    {
        $openssl = openssl_encrypt($data, $method, $password, $option);

        $ret = self::encrypt($openssl, $code);

        return $ret;
    }

    /**
     * aes Ebc 解密
     *
     * @param $str
     * @param $password
     * @param $option
     * @param $encrypt_method
     * @param $method
     * @return false|string
     */
    public static function aesEbcDecrypt($str, $password, $option = OPENSSL_RAW_DATA, $encrypt_method = 'base64',$method='AES-128-ECB')
    {
        $str = self::decrypt($str,$encrypt_method);

        $data = openssl_decrypt($str, $method, $password, $option);

        return $data;
    }

    /**
     * aes Cbc加密
     *
     * @param $data
     * @param $password
     * @param $option
     * @param $code
     * @param $method
     * @return string
     */
    function aesCbcEncrypt($data,$password, $iv = '0000000000000000', $option = OPENSSL_CIPHER_RC2_40,$code = 'base64',$method='AES-128-CBC')
    {
        $openssl = openssl_encrypt($data, $method, $password, $option, $iv);

        $ret = self::encrypt($openssl, $code);

        return $ret;
    }

    /**
     * aes Cbc 解密
     *
     * @param $str
     * @param $password
     * @param $option
     * @param $encrypt_method
     * @param $method
     * @return false|string
     */
    public static function aesCbcDecrypt($str, $password, $iv = '0000000000000000',$option = OPENSSL_CIPHER_RC2_40, $encrypt_method = 'base64',$method='AES-128-CBC')
    {
        $str = self::decrypt($str,$encrypt_method);

        $data = openssl_decrypt($str, $method, $password, $option, $iv);

        return $data;
    }
}
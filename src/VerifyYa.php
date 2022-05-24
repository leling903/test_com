<?php

namespace Yiyan\TestCom;


class VerifyYa
{

    /**
     * 判断是否为两位小数
     *
     * @param $num
     * @return bool
     */
    public static function is_2float($num)
    {

        if (preg_match('/^[0-9]+(.[0-9]{2})$/', $num)) {

            return true;
        }else{
            return false;
        }

    }

    /**
     * 银行卡号luhn校验
     *
     * @param $bankNo
     * @return bool
     */
    public static function bank_luhn($bankNo)
    {
        // 奇数之和
        $sumOdd = 0;
        // 偶数之和
        $sumEven = 0;
        // 长度
        $length = strlen($bankNo);
        $wei = [];
        for ($i = 0; $i < $length; $i++) {
            $wei[$i] = substr($bankNo, $length - $i - 1, 1);// 从最末一位开始提取，每一位上的数值
        }
        for ($i = 0; $i < $length / 2; $i++) {
            $sumOdd += $wei[2 * $i];
            if(!isset($wei[2 * $i + 1])) continue;// 如果为19位卡号，要防止报Notice: Undefined offset错误
            if (($wei[2 * $i + 1] * 2) > 9)
                $wei[2 * $i + 1] = $wei[2 * $i + 1] * 2 - 9;
            else
                $wei[2 * $i + 1] *= 2;
            $sumEven += $wei[2 * $i + 1];
        }
        if (($sumOdd + $sumEven) % 10 == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 校验手机号码
     *
     * @param $value
     * @return bool
     */
    public static function isMobile($value)
    {
        $isMob = '^1(3|4|5|6|7|8|9)[0-9]\d{8}$^';//手机规则

        if (preg_match($isMob,$value)) {//满足其中一个条件就可以

            return true;
        } else {

            return false;
        }
    }

    /**
     * 是否从微信请求过来的
     *
     * @return bool
     */
    public static function isWechatRequest()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {

            return false;
        }

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($user_agent, 'MicroMessenger') === false) {

            // 非微信浏览器禁止浏览
            return false;
        } else {

            // 获取版本号
            preg_match('/.*?(MicroMessenger\/([0-9.]+))\s*/', $user_agent, $matches);

            return true;
        }
    }

    /**
     * 校验身份证号
     *
     * @param $IDCard
     * @return bool
     */
    public static function validateIDCard($IDCard)
    {
        if (strlen($IDCard) == 18) {

            return self::check18IDCard($IDCard);
        } elseif ((strlen($IDCard) == 15)) {

            $IDCard = self::convertIDCard15to18($IDCard);

            return self::check18IDCard($IDCard);
        } else {

            return false;
        }
    }

    /**
     * 计算身份证的最后一位验证码,根据国家标准GB 11643-1999
     *
     * @param $IDCardBody
     * @return false|string
     */
    public static function calcIDCardCode($IDCardBody)
    {
        if (strlen($IDCardBody) != 17) {
            return false;
        }

        //加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码对应值
        $code = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        $checksum = 0;

        for ($i = 0; $i < strlen($IDCardBody); $i++) {
            $checksum += substr($IDCardBody, $i, 1) * $factor[$i];
        }

        return $code[$checksum % 11];
    }

    /**
     * 将15位身份证升级到18位
     *
     * @param $IDCard
     * @return false|string
     */
    public static function convertIDCard15to18($IDCard)
    {
        if (strlen($IDCard) != 15) {
            return false;
        } else {
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($IDCard, 12, 3), array('996', '997', '998', '999')) !== false) {
                $IDCard = substr($IDCard, 0, 6) . '18' . substr($IDCard, 6, 9);
            } else {
                $IDCard = substr($IDCard, 0, 6) . '19' . substr($IDCard, 6, 9);
            }
        }
        $IDCard = $IDCard . self::calcIDCardCode($IDCard);
        return $IDCard;
    }

    /**
     * 18位身份证校验码有效性检查
     *
     * @param $IDCard
     * @return bool
     */
    public static function check18IDCard($IDCard)
    {
        if (strlen($IDCard) != 18) {
            return false;
        }

        $IDCardBody = substr($IDCard, 0, 17); //身份证主体
        $IDCardCode = strtoupper(substr($IDCard, 17, 1)); //身份证最后一位的验证码

        if (self::calcIDCardCode($IDCardBody) != $IDCardCode) {
            return false;
        } else {
            return true;
        }
    }


}


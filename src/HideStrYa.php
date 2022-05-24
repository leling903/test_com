<?php

namespace Yiyan\TestCom;

class HideStrYa
{
    /**
     * 隐藏银行卡号
     *
     * @param $value
     * @return mixed|string
     */
    public static function hideCardno($value)
    {
        if (empty($value)) {

            return $value;
        }

        return substr($value,0,4).'****'.substr($value,-4);
    }

    /**
     * 隐藏手机号
     *
     * @param $value
     * @return array|mixed|string|string[]
     */
    public static function hideMobile($value)
    {
        if (empty($value)) {

            return $value;
        }

        return substr_replace($value,'****',3,4);
    }

    /**
     * 隐藏身份证号
     *
     * @param $idcardno
     * @return array|mixed|string|string[]|null
     */
    public static function hideIdcardno($idcardno)
    {
        if (empty($idcardno)) {

            return $idcardno;
        }

        return preg_replace("/(\d{3,4})\d{11}(\d{1,2})/", "\$1***********\$2", $idcardno);
    }

    /**
     * 隐藏姓名
     *
     * @param $realname
     * @return array|mixed|string|string[]
     */
    public static function hideRealname($realname)
    {
        if (empty($realname)) {

            return $realname;
        }

        return substr_replace($realname,'**',3,6);
    }
}
<?php

namespace Yiyan\TestCom;

class FuncYa
{
    /**
     * 根据身份证获取年龄
     *
     * @param $id
     * @return int|string
     */
    public static function getAge($id)
    {

        # 1.从身份证中获取出生日期
        $id = strval($id);

        $birth_Date = strtotime(substr($id, 6, 8));//截取日期并转为时间戳

        # 2.格式化[出生日期]
        $Year = date('Y', $birth_Date);//yyyy
        $Month = date('m', $birth_Date);//mm
        $Day = date('d', $birth_Date);//dd

        # 3.格式化[当前日期]
        $current_Y = date('Y');//yyyy
        $current_M = date('m');//mm
        $current_D = date('d');//dd

        # 4.计算年龄()
        $age = $current_Y - $Year;//今年减去生日年
        if($Month > $current_M || $Month == $current_M && $Day > $current_D){//深层判断(日)
            $age--;//如果出生月大于当前月或出生月等于当前月但出生日大于当前日则减一岁
        }

        # 返回
        return $age;
    }

    /**
     * 中奖率函数
     *
     * @param $proArr
     * @return int|string
     */
    public static function get_rand($proArr)
    {
        $result = '';

        //概率数组的总概率精度
        $proSum = array_sum($proArr);

        //概率数组循环
        foreach($proArr as $key => $proCur)
        {
            // 获取随机数
            $randNum = mt_rand(1, $proSum);
            if($randNum <= $proCur)
            {
                $result = $key;
                break;
            }
            else
            {
                // 减掉当前中奖的概率
                $proSum -= $proCur;
            }
        }
        unset ($proArr);

        return $result;
    }

    /**
     * 数组中随机几个元素
     *
     * @param $arr
     * @param $num
     * @return array
     */
    public static function arrRand($arr, $num)
    {
        $keys = array_rand($arr, $num);

        $newArr = [];

        foreach ($keys as $v) {
            $newArr[] = $arr[$v];
        }

        return $newArr;
    }

    /**
     * 逐行读取文件
     *
     * @param $path
     * @return array
     */
    public static function read($path)
    {
        $file = fopen($path, "r");
        $user=array();
        $i=0;
        //输出文本中所有的行，直到文件结束为止。
        while(! feof($file))
        {
            $user[$i]= trim(fgets($file));//fgets()函数从文件指针中读取一行
            $i++;
        }
        fclose($file);
        $user=array_filter($user);
        return $user;
    }

    /**
     * 获取客户端IP
     *
     * @param $type
     * @return mixed
     */
    public static function get_real_ip($type = 0)
    {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if(!empty(array_get($_SERVER, 'HTTP_X_REAL_IP'))){//nginx 代理模式下，获取客户端真实IP
            $ip=$_SERVER['HTTP_X_REAL_IP'];
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
        }else{
            $ip=isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}
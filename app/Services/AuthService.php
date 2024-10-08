<?php
/**
 * Created by PhpStorm.
 * User: qinyuan
 * Date: 2017/11/9
 * Time: 13:53
 */

namespace App\Services;


class AuthService
{
    const TOKEN_PREFIX = 'whb_applet_api_token_';

    /**
     * 根据密钥生成token
     * @param $userId
     * @param int $ttl token 存活时间
     * @return bool|string
     */
    public static function createApiToken($userId,  $isAdmin = 0 ,$ttl = 86400 )
    {
        $nTime = time()+$ttl;

        $token = self::getTokenKey($userId,$nTime,$isAdmin);

        return $token;

    }

    /**
     * 根据条件获取api token key
     * @param $userId
     * @param int $ttl token 存活时间
     * @return string
     */
    public static function getTokenKey($userId,$ttl,$isAdmin)
    {
        return base64_encode(self::encrypt(self::TOKEN_PREFIX . "{$userId}_" .$ttl."_".$isAdmin,"E")) ;
    }


    /**
     * 函数名称:encrypt
    函数作用:加密解密字符串
    使用方法:
    加密     :encrypt('str','E','nowamagic');
    解密     :encrypt('被加密过的字符串','D','nowamagic');
    参数说明:
    $string   :需要加密解密的字符串
    $operation:判断是加密还是解密:E:加密   D:解密
    $key      :加密的钥匙(密匙);
     *********************************************************************/

    public static function encrypt($string,$operation,$key='dodoca2014AdminJS'){

        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++){
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }


        for($j=$i=0;$i<256;$i++){

            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }

        for($a=$j=$i=0;$i<$string_length;$i++){

            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }

        if($operation=='D'){

            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                return substr($result,8);
            }else{
                return'';
            }
        }else{
            return str_replace('=','',base64_encode($result));
        }
    }
}
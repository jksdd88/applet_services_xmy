<?php

namespace App\Http\Controllers\Admin\Xiu;

use App\Http\Controllers\Controller;
//use App\Http\Controllers\Admin\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class XiuController extends Controller {

    /**
     * 获取客服中心链接
     *
     * @return Response
     */
    public function getLink() {
        //dd(Auth::user()->id);
        $xiu_link = 'http://xiu.dodoca.com/pc/index.html?token='.$this->encrypt('xiaochengxu:'.Auth::user()->merchant_id,'E','dodoca2014AdminJS');
        
        $rt['errcode']=0;
        $rt['errmsg']='获取点点秀链接地址';
        $rt['data']= array('xiu_link'=>$xiu_link);
        return response::json($rt);
        //return Redirect::to(custservice_link);
    }

    /**
     * 函数名称:encrypt
     * 函数作用:加密解密字符串
     * 使用方法:
     * 加密     :encrypt('str','E','nowamagic');
     * 解密     :encrypt('被加密过的字符串','D','nowamagic');
     * 参数说明:
     * $string   :需要加密解密的字符串
     * $operation:判断是加密还是解密:E:加密   D:解密
     * $key      :加密的钥匙(密匙);
     *********************************************************************/
    
    static function encrypt($string, $operation, $key = 'dodoca2014AdminJS')
    {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for($i = 0; $i <= 255; $i++)
        {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
    
    
        for($j = $i = 0; $i < 256; $i++)
        {
    
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
    
        for($a = $j = $i = 0; $i < $string_length; $i++)
        {
    
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
    
        if($operation == 'D')
        {
    
            if(substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8))
            {
                return substr($result, 8);
            }
            else
            {
                return '';
            }
        }
        else
        {
            return str_replace('=', '', base64_encode($result));
        }
    }
    
}

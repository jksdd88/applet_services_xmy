<?php

/**
 * 分销买家与推客关系表Model
 * @author 郭其凯
 * @package App\Models
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Utils\CacheKey;
use Illuminate\Support\Facades\Cache;

class DistribBuyerRelation extends Model
{

    protected $table   = 'distrib_buyer_relation';
    protected $guarded = ['id'];
    public $timestamps = false;



    /**
     * 插入一条记录
     * @return id
     */
    static function insert_data($data)
    {
        $data['created_time'] = date('Y-m-d H:i:s');
        $data['updated_time'] = date('Y-m-d H:i:s');
        return self::insertGetId($data);
    }

    /**
     * 通过id查询一条记录
     * @return array
     */

    static function get_data_by_memberid($member_id , $merchant_id)
    {
        if(!$member_id || !is_numeric($member_id))return;
        if(!$merchant_id || !is_numeric($merchant_id))return;

        $key = CacheKey::get_distrib_buyer_relation_byid_key($member_id, $merchant_id);
        $data = Cache::get($key);
        if(!$data)
        {
            $data = self::where(['member_id'=>$member_id, 'merchant_id'=>$merchant_id])->first();

            if($data)
            {
                Cache::put($key, $data, 120);
            }

        }

        return $data;

    }


    /**
     * 修改一条记录
     * @return int|修改成功条数
     */

    static function update_data($member_id ,$merchant_id ,$data)
    {
        if(!$member_id || !is_numeric($member_id))return;
        if(!$merchant_id || !is_numeric($merchant_id))return;

        $key = CacheKey::get_distrib_buyer_relation_byid_key($member_id ,$merchant_id);
        Cache::forget($key);

        $data['updated_time'] = date('Y-m-d H:i:s');
        return self::query()->where(['member_id'=>$member_id,'merchant_id'=>$merchant_id])->update($data);

    }

}
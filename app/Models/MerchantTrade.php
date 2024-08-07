<?php
/**
 * 商户支付交易表
 * 
 */
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantTrade extends Model
{
   
    protected $table = 'merchant_trade';
	const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
	
     /**
	 * 插入数据
	 */
    static function insert_data($data)
    {
        $data['created_time'] = date('Y-m-d H:i:s');
        $data['updated_time'] = date('Y-m-d H:i:s');
        return self::insertGetId($data);
    }

    /**
	 * 获取单条数据
	 */
    static function get_data_by_id($id, $merchant_id, $fields = '*')
    {
        if(!$id || !is_numeric($id))return;
        if(!$merchant_id || !is_numeric($merchant_id))return;
		$data = self::query()->select(\DB::raw($fields))->where(['id'=>$id,'merchant_id'=>$merchant_id])->first();
        return $data;
    }

    /**
	 * 修改数据
	 */
    static function update_data($id, $merchant_id, $data)
    {
        if(!$id || !is_numeric($id))return;
        if(!$merchant_id || !is_numeric($merchant_id))return;
		$data['updated_time'] = date('Y-m-d H:i:s');
        return self::query()->where(['id'=>$id,'merchant_id'=>$merchant_id])->update($data);
    }
	
    /**
     * count记录条数
     * @return int|count
     */
    static function get_data_count($wheres=array())
    {
        $query = self::query();
        foreach($wheres as $where) {
            $query->where($where['column'], $where['operator'], $where['value']);
        }
        return $query->count();
    }

    /**
     * 查询多条记录
     * @return array
     */
    static function get_data_list($wheres=array(), $fields = '*', $offset = 0, $limit = 10)
    {
        $query = self::query();
        foreach($wheres as $where) {
            $query->where($where['column'], $where['operator'], $where['value']);
        }
        $data = $query->select(\DB::raw($fields))->skip($offset)->take($limit)->orderBy('created_time', 'desc')->get();
        return json_decode($data,true);
    }


}

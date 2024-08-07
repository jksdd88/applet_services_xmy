<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AloneActivityRecode extends Model
{
    protected $table='alone_activity_recode';
    protected $guarded = ['id'];
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_time';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_time';


    /**
     * 查询商品正在参加活动信息
     * @param $goods_id
     * @param $merchant_id
     * @author: tangkang@dodoca.com
     * @return 商品参加活动类型 tuan：拼团，seckill：秒杀。为空则当前没参加活动
     */
    static function get_data_by_goodsid($goods_id,$merchant_id)
    {
        if(!$goods_id || !is_numeric($goods_id))return;
        if(!$merchant_id || !is_numeric($merchant_id))return;

        $today = date('Y-m-d H:i:s');

        $data = AloneActivityRecode::where('goods_id', $goods_id)
            ->select(\DB::raw('act_type,alone_id'))
            ->where('merchant_id','=',$merchant_id)
            ->where('start_time','<=',$today)
            ->where(function($query){
                $query->where('finish_time','=','0000-00-00 00:00:00')//团购无，秒杀必须有
                    ->orWhere('finish_time','>',date('Y-m-d H:i:s'));
            })
            ->orderBy('alone_id', 'desc')
            ->first();

        return $data;
    }

    /**
     * 查询多条记录
     *@param  $wheres['where'] 查询条件 二维数组
     *@param  $wheres['select'] 保留字段 v,v,v,v
     *@param  $wheres['wherein'] 查询条件 二维数组  k=>[][,k=>[]]
     *@param  $wheres['orderBy'] 排序条件 一维数组 k=>v,k=>v
     *@param  $wheres['offset'] 起始位置    v
     *@param  $wheres['limit'] 查询几条     v
     *@param  $wheres['lists'] lists    v[,v]
     *@param  $wheres['get'] get()
     *@param  $wheres['toArray'] toArray()
     *@return array
     *@author  renruiqi
     */
    static function get_data_list_new($wheres=array())
    {
        if(!$wheres) return;
        $query = self::query();
        if(isset($wheres['select'])){
            $query = $query->select(\DB::raw($wheres['select']));
        }
        if(isset($wheres['where'])){
            foreach($wheres['where'] as $v){
                $query = $query->where($v['column'], $v['operator'], $v['value']);
            }
        }
        if(isset($wheres['whereIn'])){
            foreach($wheres['whereIn'] as $k=>$v){
                $query = $query->whereIn($k,$v);
            }
        }
        if(isset($wherse['orderBy'])){
            foreach($wheres['orderBy'] as $k=>$v){
                $query = $query->orderBy($k,$v);
            }
        }
        if(isset($wheres['offset'])&&isset($wheres['limit'])){
            $query = $query->offset($wheres['offset'])->limit($wheres['limit']);
        }
        if(isset($wheres['lists'])){
            if(count($wheres['lists'])==2){
                $data = $query->lists($wheres['lists'][0],$wheres['lists'][1]);
            }else{
                $data = $query->lists($wheres['lists'][0]);
            }
        }
        if(isset($wheres['get'])){
            $data = $query->get();
        }
        if(isset($wheres['toArray'])){
            if(empty($data)||count($data)<1) return [];
            $data = $data->toArray();
        }
        return $data;
    }
}

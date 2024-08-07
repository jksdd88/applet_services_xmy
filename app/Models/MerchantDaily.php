<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-27
 * Time: 下午 01:36
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MerchantDaily extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'merchant_daily';//会员每天统计

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    protected $connection = 'applet_stats';


    /**
     * 查询一条记录
     * @return array
     */

    static function get_data_by_id($day)
    {
        $data = self::query()->where('day_time','=',$day)->first();
        return $data;

    }

    /**
     * 根据条件更新一条数据
     * @return int|修改成功条数
     */

    static function update_data_by_where( $wheres = [], $data)
    {
        $query = self::query();
        foreach($wheres as $where) {
            $query->where($where['column'], $where['operator'], $where['value']);
        }
        return $query->update($data);
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
        $data = $query->select(\DB::raw($fields))->skip($offset)->take($limit)->orderBy('day_time', 'desc')->get();
        return json_decode($data,true);
    }
}
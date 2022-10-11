<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use HasFactory;

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = 'create_time';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = 'update_time';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const DELETED_AT = 'delete_time';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * @param array $attributes
     * @param string|null $value
     * @param string|null $default
     * @return array|mixed
     */
    protected function getEnumeration(array $attributes = [], ?string $value = null, ?string $default = '--'): mixed
    {
        $attributes = array_change_key_case($attributes, CASE_LOWER);
        return is_null($value) ? $attributes : with($attributes, function ($attributes) use ($value, $default) {
            return array_key_exists($value = strtolower($value), $attributes) ? $attributes[$value] : $default;
        });
    }

    /**
     * 金额统一转换
     *
     * @param int|null $scale
     * @return Attribute
     */
    protected function getMoney(?int $scale = 4): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => bcdiv($value, 10000, $scale),
            set: fn($value, $attributes) => bcmul($value, 10000, $scale),
        );
    }

    public function helpBlock(string $block = ''): mixed
    {
        $cpc_min_time           = config('system.cpc_min_time', 300);
        $cpv_min_time           = config('system.cpv_min_time', 300);
        $exchange_charging_type = config('system.exchange_charging_type', 'cpc') == 'cpc' ? '点击' : '展示';
        // help block
        $blocks = [
            'origin' => [
                'union' => '广告位展示联盟广告资源',
                'local' => '广告位不匹配联盟广告资源，您可以在【空闲设置】中自定义展示内容',
            ],
            'type' => [
                'default' => '自动匹配广告类型',
                'cpc' => "按点击付费，{$cpc_min_time}秒内重复点击不计费",
                'cpm' => '按一天24小时内，每条广告资源在每个广告位内1000个IP地址付费',
                'cpv' => "按展示付费，{$cpv_min_time}秒内重复展示不计费",
                'cpa' => '按下载、注册等行为付费',
                'cps' => '按成交订单金额比例付费',
            ],
            'vacant' => [
                'exchange' => "未匹配到广告资源时所有站点之间互相引量，按{$exchange_charging_type}计算换量权重",
                'default' => '未匹配到广告资源时显示您自定义的广告',
                'union' => '未匹配到广告资源时使用第三方广告联盟代码',
                'fixed' => '未匹配到广告资源时显示联盟公益广告',
                'hidden' => '未匹配到广告资源时隐藏当前广告位',
            ],
        ];

        foreach (explode('.', $block) as $key) {
            if ($key) {
                $blocks = array_key_exists($key, $blocks) ? $blocks[$key] : [];
            }
        }

        return $blocks;
    }
}

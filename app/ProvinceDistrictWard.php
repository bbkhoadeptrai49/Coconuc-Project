<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProvinceDistrictWard extends Model
{
    protected $fillable = ['province_name', 'province_id', 'province_code', 'district_name', 'district_code', 'district_id', 'ward_name', 'code', 'ward_code'];

    /**
     * @var string
     */
    protected $table = 'province_district_ward';

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}

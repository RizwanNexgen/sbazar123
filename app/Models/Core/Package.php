<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packages';

    /**
     * The table primary key. Eloquent will also assume that each table has a primary key column named id. 
     * You may define a protected $primaryKey property to override this convention.
     *
     * @var bool
     */
    public $primaryKey = 'id'; 
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;   

    public function package_info(){
        return $this->hasMany('App\Models\Core\PackageInfo', 'package_id')->where('language_id', 1)->first();
    }

    public function package_products(){
        return $this->hasMany('App\Models\Core\PackageProduct', 'package_id');
    }

    

    public function parent_package() {
        return $this->belongsTo(static::class, 'parent_id')->first();
    }
}

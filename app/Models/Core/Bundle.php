<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bundles';

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

    public function bundle_info(){
        return $this->hasMany('App\Models\Core\BundleInfo', 'bundle_id')->where('language_id', 1)->first();
    }

    public function bundle_products(){
        return $this->hasMany('App\Models\Core\BundleProduct', 'bundle_id');
    }
}

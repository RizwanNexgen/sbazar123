<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class SuperDeals extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'super_deals';

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

    public function super_deals_info(){
        return $this->hasMany('App\Models\Core\SuperDealsInfo', 'super_deals_id')->where('language_id', 1)->first();
    }
}

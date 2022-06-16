<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'combos';

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

    public function combo_info(){
        return $this->hasMany('App\Models\Core\ComboInfo', 'combo_id')->where('language_id', 1)->first();
    }

    public function combo_products(){
        return $this->hasMany('App\Models\Core\ComboProduct', 'combo_id');
    }
}

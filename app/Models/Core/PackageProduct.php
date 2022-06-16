<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packages_products';

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
    public $timestamps = false; 

    public function product(){
        return $this->belongsTo('App\Models\Core\Products', 'product_id')->first();
    }

    
}

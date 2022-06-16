<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class ComboProduct extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'combos_products';

    /**
     * The table primary key. Eloquent will also assume that each table has a primary key column named id. 
     * You may define a protected $primaryKey property to override this convention.
     *
     * @var bool
     */
    public $primaryKey = 'combo_product_id'; 
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; 
}

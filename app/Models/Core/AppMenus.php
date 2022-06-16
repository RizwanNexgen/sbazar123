<?php

namespace App\Models\Core;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use Illuminate\Database\Eloquent\Model;

class AppMenus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_menus';

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
}

<?php

namespace App\Models\AppModels;

use Illuminate\Database\Eloquent\Model;


class Address extends Model
{

    protected $table = 'address_book';
   protected $primaryKey = 'address_book_id';
  public $timestamps = false;

}

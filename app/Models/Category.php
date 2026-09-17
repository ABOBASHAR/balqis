<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
        // we can also specify the foreign key and local key 
        // if they are different from the default conventions. 
        // =======================================================
        // return $this->hasMany(Product::class, 'category_id', 'id');
        // the first parameter is the related model,
        //  the second parameter is the foreign key on
        //  the related model, and the third parameter is
        //  the local key on the current model.
        
    }
}

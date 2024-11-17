<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['subcategory_name','subcate_slug','category_id'];

    //Eloquent orm er jonno database join kora hocce ekhane
    public function category()
    {
      return $this->belongsTo(Category::class);
    }

}

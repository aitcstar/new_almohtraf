<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    public $table = 'categories';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'logo',
        'parent_id',
        'status'
    ];

    // العلاقة مع الفئات الفرعية
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // العلاقة مع الفئة الرئيسية
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // العلاقة مع المشاريع التي ترتبط بهذه الفئة الرئيسية
    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }

    // العلاقة مع المشاريع التي ترتبط بهذه الفئة كفئة فرعية
    public function subCategoryProjects()
    {
        return $this->hasMany(Project::class, 'subcategory_id');
    }


}

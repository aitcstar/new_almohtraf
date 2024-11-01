<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function getAllCategories(request $request)
    {
        //$categories = Category::whereNull('parent_id')->orderBy('id', 'ASC')->get();
        // استرجاع الأقسام الرئيسية فقط مع الفئات الفرعية والمشاريع المرتبطة
        $categories = Category::whereNull('parent_id')
        ->with(['subCategories.subCategoryProjects', 'projects'])
        ->get();

        return view('frontend.category', compact('categories'));
    }

}

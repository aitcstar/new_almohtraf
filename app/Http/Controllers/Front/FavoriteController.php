<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Project;
use App\Models\Portfolio;

class FavoriteController extends Controller
{

    // عرض قائمة المفضلة مع الفلاتر
    public function index(Request $request)
    {
       // فلترة المفضلات حسب النوع
       $typeFilter = $request->query('type');
       $favoritesQuery = Favorite::with('favoritable')->where('user_id', auth()->id());

       if ($typeFilter) {
           $favoritesQuery->where('favoritable_type', 'App\Models\\' . ucfirst($typeFilter));
       }

       $favorites = $favoritesQuery->get();


        return view('frontend.favorites.index', compact('favorites'));

    }


 // إضافة للمفضلة
 public function add(Request $request)
 {

    $request->validate([
        'favoritable_type' => 'required|string',
        'favoritable_id' => 'required|integer',
    ]);
    // تحقق مما إذا كانت المفضلة موجودة بالفعل
    if (Favorite::where('user_id', auth()->id())
                ->where('favoritable_type', $request->favoritable_type)
                ->where('favoritable_id', $request->favoritable_id)
                ->exists()) {

        return redirect()->back()->with('message','تمت إضافة هذا العنصر إلى المفضلات مسبقًا.');
    }

    Favorite::create([
        'user_id' => auth()->id(),
        'favoritable_type' => $request->favoritable_type,
        'favoritable_id' => $request->favoritable_id,
    ]);



    return redirect()->back()->with('message','تمت الإضافة إلى المفضلة بنجاح.');

        //return response()->json(['message' => 'تمت الإضافة إلى المفضلة بنجاح.'], 200);
 }

  // حذف المفضلة
 public function remove($id)
 {
    $favorite = Favorite::findOrFail($id);
    $favorite->delete();

    return redirect()->back()->with('message','تم حذف العنصر من المفضلة.');

 }

}

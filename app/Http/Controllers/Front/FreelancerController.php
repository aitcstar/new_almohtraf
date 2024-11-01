<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Portfolio;
use App\Models\PortfolioFile;
use App\Models\PortfolioView;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;

class FreelancerController extends Controller
{

    public function index(request $request){

        $onlineFreelancers = User::where('status', 'online')
        ->where('freelancer_availability', 1) // شرط أن يكون المستخدم Freelancer
        ->paginate(10);

       // حساب نسبة إكمال المشاريع لكل فريلانسر
        foreach ($onlineFreelancers as $freelancer) {
            $freelancer->completionRate = $freelancer->calculateCompletionRate();
        }

        $categories = Project::getCategoryParent();

        return view('frontend.freelancers.index', compact('onlineFreelancers','categories'));
    }

     // لعرض قائمة المشاريع مع إمكانية الفلترة
     public function list(Request $request)
     {
        //dd('1');
         $categories = Project::getCategoryParent();
         $query = User::query();
         // فلترة المشاريع حسب الأقسام المحددة
         if ($request->has('category_ids')) {
             $categoryIds = $request->input('category_ids');
             $query->whereIn('category_id', $categoryIds)->orderBy('id', 'DESC');
         }

        // dd('2');
         $onlineFreelancers = $query->where('status', 'online')
         ->where('freelancer_availability', 1) // شرط أن يكون المستخدم Freelancer
         ->paginate(10);
         //dd('3');
         // حساب نسبة إكمال المشاريع لكل فريلانسر
        foreach ($onlineFreelancers as $freelancer) {
            $freelancer->completionRate = $freelancer->calculateCompletionRate();
        }


         return view('frontend.freelancers.partials.freelancers-list', compact('onlineFreelancers','categories'))->render();
     }

     public function getUser($id){

        $user = User::where('id',$id)->first();
        $accountTypeIds = $user->accountTypes->toArray();
        $skills =  $user->load('skills');
        $completionRate = $user->calculateCompletionRate();
        $hiringRate = $user->calculateHiringRate();
        $rehireRate = $user->calculateRehireRate();
        $onTimeDeliveryRate = $user->calculateOnTimeDeliveryRate();
        $averageTime = $user->averageResponseTime();
        $reviews = $user->reviewsReceived()->with('project')->get(); // assuming user has reviews() relationship

        return view('frontend.freelancers.user', compact('user','accountTypeIds','skills','completionRate','hiringRate','rehireRate','onTimeDeliveryRate','averageTime','reviews'));


     }
     public function showPortfolio($id){
        //dd($id);
        //$user = $portfolio->where('')->first();
        $portfolio = Portfolio::where('id' , $id )->first();

        //dd($portfolio);

        if(!$portfolio ){
            return redirect()->back();
        }

        $skills = $portfolio->load('skills');

        return view('frontend.freelancers.portfolio', compact('portfolio','skills'));

     }


     /*
     public function listSubCategory(Request $request)
     {
        // dd($request->subCategory);
         $categories = Project::getCategoryParent();
         $query = User::query();
         // فلترة المشاريع حسب الأقسام المحددة
         //if ($request->has('subcategory_id')) {
             $categoryId = $request->subCategory;
             $onlineFreelancers = $query->where('subcategory_id', $categoryId)->where('order_status_id', 1)
             ->where('status', 'online')
             ->where('freelancer_availability', 1)->paginate(10);
         // حساب نسبة إكمال المشاريع لكل فريلانسر
        foreach ($onlineFreelancers as $freelancer) {
            $freelancer->completionRate = $freelancer->calculateCompletionRate();
        }


         return view('frontend.freelancers.index', compact('projects','categories'));

     }
*/
}

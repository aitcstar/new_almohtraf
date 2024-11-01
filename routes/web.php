<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\ProjectController as FrontProjectController;
use App\Http\Controllers\BoardingController;
use App\Http\Controllers\Front\FreelancerController;
use App\Http\Controllers\Front\NotificationController;
use App\Http\Controllers\Front\MessageController;
use App\Http\Controllers\Front\WalletController;
use App\Http\Controllers\Front\FavoriteController;
use App\Http\Controllers\Front\ProjectReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Front\ReportController;
// Admin Controllers
use App\Http\Controllers\Admin\{
    RoutingController,
    UserController,
    OrdersController,
    CurrenciesController,
    DashboardAuthController,
    AccountTypeController,
    CategoryController,
    SubCategoryController,
    SkillController,
    SliderController,
    OrderStatusController,
    ProjectController as AdminProjectController,
    PageController,
    SettingController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Dashboard Authentication
Route::get('dashboard/login', [DashboardAuthController::class, 'showLoginForm'])->name('dashboard.login');
Route::post('login', [DashboardAuthController::class, 'login'])->name('dashboard.login.submit');

/*

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
*/
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'admin']], function () {

    // Routing
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
    Route::get('{first}/home/index', [DashboardAuthController::class, 'index'])->name('home.index');

    // Account Types
    Route::prefix('{first}/accounttypes')->name('accounttypes.')->group(function () {
        Route::get('index', [AccountTypeController::class, 'index'])->name('index');
        Route::get('create', [AccountTypeController::class, 'create'])->name('create');
        Route::post('store', [AccountTypeController::class, 'store'])->name('store');
        Route::get('edit/{id}', [AccountTypeController::class, 'edit'])->name('edit');
        Route::post('update', [AccountTypeController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [AccountTypeController::class, 'destroy'])->name('destroy');
    });

    // Categories
    Route::prefix('{first}/categories')->name('categories.')->group(function () {
        Route::get('index', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('update', [CategoryController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // SubCategories
    Route::prefix('{first}/subcategories')->name('subcategories.')->group(function () {
        Route::get('index', [SubCategoryController::class, 'index'])->name('index');
        Route::get('create', [SubCategoryController::class, 'create'])->name('create');
        Route::post('store', [SubCategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SubCategoryController::class, 'edit'])->name('edit');
        Route::post('update', [SubCategoryController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [SubCategoryController::class, 'destroy'])->name('destroy');
    });

    // Skills
    Route::prefix('{first}/skills')->name('skills.')->group(function () {
        Route::get('index', [SkillController::class, 'index'])->name('index');
        Route::get('create', [SkillController::class, 'create'])->name('create');
        Route::post('store', [SkillController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SkillController::class, 'edit'])->name('edit');
        Route::post('update', [SkillController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [SkillController::class, 'destroy'])->name('destroy');
    });

    // Sliders
    Route::prefix('{first}/sliders')->name('sliders.')->group(function () {
        Route::get('index', [SliderController::class, 'index'])->name('index');
        Route::get('create', [SliderController::class, 'create'])->name('create');
        Route::post('store', [SliderController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SliderController::class, 'edit'])->name('edit');
        Route::post('update', [SliderController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [SliderController::class, 'destroy'])->name('destroy');
    });

     // Projects
     Route::prefix('{first}/projects')->name('adminProjects.')->group(function () {
        Route::get('index', [AdminProjectController::class, 'index'])->name('index');
        Route::get('create', [AdminProjectController::class, 'create'])->name('create');
        Route::post('store', [AdminProjectController::class, 'store'])->name('store');
        Route::get('edit/{id}', [AdminProjectController::class, 'edit'])->name('edit');
        Route::post('update', [AdminProjectController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [AdminProjectController::class, 'destroy'])->name('destroy');
    });


    // Order Status
    Route::prefix('{first}/orderstatus')->name('orderstatus.')->group(function () {
        Route::get('index', [OrderStatusController::class, 'index'])->name('index');
        Route::get('create', [OrderStatusController::class, 'create'])->name('create');
        Route::post('store', [OrderStatusController::class, 'store'])->name('store');
        Route::get('edit/{id}', [OrderStatusController::class, 'edit'])->name('edit');
        Route::post('update', [OrderStatusController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [OrderStatusController::class, 'destroy'])->name('destroy');
    });

    // Terms and Privacy and fees
    Route::prefix('{first}/terms')->name('terms.')->group(function () {
        Route::get('index', [PageController::class, 'index'])->name('index');
        Route::post('update', [PageController::class, 'update'])->name('update');
    });

    Route::prefix('{first}/privacy')->name('privacy.')->group(function () {
        Route::get('index', [PageController::class, 'privacyIndex'])->name('index');
        Route::post('update', [PageController::class, 'privacyUpdate'])->name('update');
    });

    Route::prefix('{first}/guarantee')->name('guarantee.')->group(function () {
        Route::get('index', [PageController::class, 'guaranteeIndex'])->name('index');
        Route::post('update', [PageController::class, 'guaranteeUpdate'])->name('update');
    });


    Route::prefix('{first}/fees')->name('fees.')->group(function () {
        Route::get('index', [PageController::class, 'feesIndex'])->name('index');
        Route::post('update', [PageController::class, 'feesUpdate'])->name('update');
    });

    Route::prefix('{first}/faq')->name('faq.')->group(function () {
        Route::get('index', [PageController::class, 'faqIndex'])->name('index');
        Route::post('update', [PageController::class, 'faqUpdate'])->name('update');
    });

    // Settings
    Route::prefix('{first}/settings')->name('settings.')->group(function () {
        Route::get('index', [SettingController::class, 'index'])->name('index');
        Route::get('edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::post('update', [SettingController::class, 'update'])->name('update');
    });


});

    // Frontend Routes
    Route::get('/', [IndexController::class, 'index'])->name('index');


    Route::get('login-client', [AuthController::class, 'loginClient'])->name('loginClient');
    Route::post('loginClientStore', [AuthController::class, 'loginClientStore'])->name('login.ClientStore');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('registerClient', [AuthController::class, 'registerClient'])->name('register.client');
    Route::get('verified', [AuthController::class, 'verified'])->name('verified');
    Route::get('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('restore-password', [AuthController::class, 'restorePassword'])->name('restorepassword');
    Route::get('changepassword', [AuthController::class, 'changePassword'])->name('changepassword');
    Route::post('restore-change-password', [AuthController::class, 'restoreChangePassword'])->name('restorechangepassword');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // توجيه المستخدم إلى صفحة تسجيل الدخول باستخدام جوجل
    Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');

    // استلام رد جوجل بعد محاولة تسجيل الدخول
    Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);


// Static Pages
Route::get('terms', [PageController::class, 'terms'])->name('terms');
Route::get('privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('guarantee', [PageController::class, 'guarantee'])->name('guarantee');
Route::get('fees', [PageController::class, 'fees'])->name('fees');
Route::get('faq', [PageController::class, 'faq'])->name('faq');


// تجميع مسارات المستقلين في مجموعة مشتركة مع استخدام الأسماء الواضحة
Route::prefix('freelancers')->name('freelancers.')->group(function () {
    Route::get('/', [FreelancerController::class, 'index'])->name('index'); // عرض جميع المستقلين
    Route::get('/list', [FreelancerController::class, 'list'])->name('list'); // عرض قائمة المستقلين
    Route::get('/user/{id}', [FreelancerController::class, 'getUser'])->name('getUser'); // عرض المستقلين حسب تصنيف فرعي
    Route::get('/user/portfolio/{id}', [FreelancerController::class, 'showPortfolio'])->name('showPortfolio'); // عرض المستقلين حسب تصنيف فرعي


});


Route::group(['middleware' => ['CheckBoardingStatus']], function () {


    // Categories
    Route::get('all-categories', 'App\Http\Controllers\CategoryController@getAllCategories');

    // Projects
    Route::prefix('project')->name('projects.')->group(function () {
        Route::get('index', [FrontProjectController::class, 'index'])->name('index');
        Route::get('create', [FrontProjectController::class, 'create'])->name('create');
        //Route::post('store', [FrontProjectController::class, 'store'])->name('store')->middleware('auth');
        Route::get('show/{project}', [FrontProjectController::class, 'show'])->name('show');
        Route::post('{project}/bids', [FrontProjectController::class, 'storeBid'])->name('storeBid');

        Route::get('list', [FrontProjectController::class, 'list'])->name('list');
        Route::get('list/{subCategory}', [FrontProjectController::class, 'listSubCategory'])->name('listSubCategory');
        Route::get('list/{Category}', [FrontProjectController::class, 'listCategory'])->name('listCategory');

       // Route::get('bidlist', [FrontProjectController::class, 'bidList'])->name('bidList');
        //Route::get('list/{subCategory}', [FrontProjectController::class, 'listSubCategory'])->name('listSubCategory');


    });


    Route::middleware('auth')->group(function () {
        Route::get('/my-projects', [FrontProjectController::class, 'myprojects'])->name('myprojects');
        Route::get('/project/edit/{id}', [FrontProjectController::class, 'editProject'])->name('editProject');
        Route::post('/project/update', [FrontProjectController::class, 'updateProject'])->name('updateProject');
        Route::get('/project/destroy/{id}', [FrontProjectController::class, 'destroyProject'])->name('destroyProject');
        Route::get('/project/cancel/{id}', [FrontProjectController::class, 'cancelProject'])->name('cancelProject');

        Route::get('/messages/index', [MessageController::class, 'index'])->name('message.index');
        //Route::post('/messages/{projectId}', [MessageController::class, 'store'])->name('store');
        Route::post('/projects/{projectId}/chat', [MessageController::class, 'store'])->name('message.store');
        Route::post('/projects/{projectId}/chat', [MessageController::class, 'newstore'])->name('message.newstore');


        Route::get('/projects/{projectId}/messages', [MessageController::class, 'showProjectChat'])->name('message.showProjectChat');

        Route::post('/projects/{project}/request-delivery', [FrontProjectController::class, 'requestDelivery'])->name('projects.requestDelivery');
        Route::post('/projects/{project}/approve-delivery', [FrontProjectController::class, 'approveDelivery'])->name('projects.approveDelivery');
        Route::post('/projects/{project}/reject-delivery', [FrontProjectController::class, 'rejectDelivery'])->name('projects.rejectDelivery');

        Route::post('/projects/{projectId}/reviews', [ProjectReviewController::class, 'store']);
        Route::get('/projects/{projectId}/reviews', [ProjectReviewController::class, 'show']);
        Route::get('/projects/clone/{id}', [FrontProjectController::class, 'cloneProject'])->name('projects.clone');


        Route::get('/my-bids', [FrontProjectController::class, 'myBids'])->name('myBids');
       // Route::post('/offers/accept/{id}', [FrontProjectController::class, 'acceptOffer'])->name('accept');
        Route::post('/offers/{id}/accept', [FrontProjectController::class, 'accept'])->name('accept');


        Route::post('/report', [ReportController::class, 'store'])->name('report.store');


        Route::prefix('boarding')->name('boarding.')->group(function () {
            Route::get('account', [BoardingController::class, 'account'])->name('account');
            Route::get('profile', [BoardingController::class, 'profile'])->name('profile');
            Route::get('portfolio', [BoardingController::class, 'portfolio'])->name('portfolio');
            //Route::get('acceptance', [BoardingController::class, 'acceptance'])->name('acceptance');
            Route::get('briefly', [BoardingController::class, 'briefly'])->name('briefly');

            //Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
            //Route::post('update', [ProfileController::class, 'update'])->name('update');

            Route::get('index', [BoardingController::class, 'index'])->name('index');
        });

        Route::prefix('wallet')->name('wallet.')->group(function () {
            Route::get('index', [WalletController::class, 'index'])->name('index');
            Route::post('/wallet/add-funds', [WalletController::class, 'addFunds'])->name('addFunds');
        });

        Route::prefix('favorites')->name('favorites.')->group(function () {
            Route::get('/index', [FavoriteController::class, 'index'])->name('index');
            Route::post('/favorites/add', [FavoriteController::class, 'add'])->name('add');
            Route::delete('/favorites/remove/{id}', [FavoriteController::class, 'remove'])->name('remove');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('index', [ProfileController::class, 'index'])->name('index');
            Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
            Route::post('update', [ProfileController::class, 'update'])->name('update');
            Route::get('portfolio', [ProfileController::class, 'portfolio'])->name('portfolio');
            Route::post('addPortfolio', [ProfileController::class, 'addPortfolio'])->name('addPortfolio');
            Route::get('portfolio/show/{portfolio}', [ProfileController::class, 'showPortfolio'])->name('showPortfolio');
            Route::get('portfolio/edit/{portfolio}', [ProfileController::class, 'editPortfolio'])->name('editPortfolio');
            Route::post('portfolio/update', [ProfileController::class, 'updatePortfolio'])->name('updatePortfolio');
            Route::get('destroy/{portfolio}', [ProfileController::class, 'destroyPortfolio'])->name('destroyPortfolio');

        });

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('index', [NotificationController::class, 'index'])->name('index');
            Route::get('show/{notification}', [NotificationController::class, 'show'])->name('show');
            Route::get('/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('markAsRead');
            Route::get('/unread-count', [NotificationController::class, 'getUnreadCount']);

        });


    });

});

Route::post('store', [FrontProjectController::class, 'store'])->name('store');
Route::post('boarding/update-account-types', [BoardingController::class, 'updateAccountTypes'])->name('boarding.update-account-types')->middleware('auth');
Route::post('boarding/profile', [BoardingController::class, 'updateProfile'])->name('boarding.profile')->middleware('auth');
Route::post('boarding/portfolio', [BoardingController::class, 'updatePortfolio'])->name('boarding.portfolio')->middleware('auth');
Route::delete('/portfolios/{portfolio}/delete-thumbnail', [BoardingController::class, 'deleteThumbnail'])->middleware('auth');
Route::delete('/portfolios/{portfolio}/delete-thumbnail-files', [BoardingController::class, 'deleteThumbnailFiles'])->middleware('auth');
Route::post('/user/update-info', [BoardingController::class, 'updateInfo'])->name('boarding.updateInfo')->middleware('auth');
Route::post('/update-status', [AuthController::class, 'updateStatus'])->middleware('auth');
Route::delete('/projects/{project}/delete-thumbnail-files', [FrontProjectController::class, 'deleteThumbnailFiles'])->middleware('auth');


Route::get('subcategory/{id}', [FrontProjectController::class, 'getSubCategory'])->name('getsubcategory');
Route::get('/projects/filter', [FrontProjectController::class, 'filter'])->name('filter');
Route::get('/filter-projects', [FrontProjectController::class, 'filterProjects']);



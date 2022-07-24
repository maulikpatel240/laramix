<?php

use Illuminate\Support\Facades\Route;
//Web Panel
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

//Admin Panel
use App\Http\Controllers\Admin\CustompagesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailtemplatesController;
use App\Http\Controllers\Admin\ModulesController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminController;
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

Route::get('phpmyinfo', function () {
    phpinfo();
})->name('phpmyinfo');

Route::get('/', function () {
    return redirect('admin');
});

Route::fallback(function () {
    abort(404, 'API resource not found');
});

// Auth::routes();

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function () {
        Route::get('/', function () {
            return redirect(route('admin.login'));
        });
        // Route::view('/login', 'auth.adminlogin')->name('login');
        Route::get('/login', [AdminController::class, 'index'])->name('login');
        Route::post('/login', [AdminController::class, 'login'])->name('checklogin');
        Route::get('/forgot-password', function () {
            return view('admin.passwords.email');
        })->name('password.request');
        Route::post('/forgot-password', function (Request $request) {
            $request->validate(['email' => 'required|email']);
            $status = Password::sendResetLink(
                $request->only('email')
            );
            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        })->name('password.email');
        Route::get('/reset-password/{token}', function ($token) {
            return view('admin.passwords.reset', ['token' => $token]);
        })->name('password.reset');
        Route::post('/reset-password', function (Request $request) {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ]);
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );
            return $status === Password::PASSWORD_RESET
                ? redirect()->route('admin.login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
        })->name('password.update');
    });
    Route::middleware('auth:admin', 'PreventBackHistory')->group(function () {
        // Route::view('/home', 'admin.dashboard')->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/import', [DashboardController::class, 'import'])->name('dashboard.import');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::post('/fcm-token', [DashboardController::class, 'updateToken'])->name('dashboard.fcmToken');
        Route::post('/send-notification', [DashboardController::class, 'notification'])->name('dashboard.notification');
        //Modules
        Route::prefix('modules')->name('modules.')->group(function () {
            Route::get('/', [ModulesController::class, 'index'])->name('index')->middleware('checkpermission');
            Route::post('/create', [ModulesController::class, 'create'])->name('create')->middleware('checkpermission');
            Route::post('/store', [ModulesController::class, 'store'])->name('store')->middleware('checkpermission');
            Route::post('/edit/{id}', [ModulesController::class, 'edit'])->name('edit')->middleware('checkpermission');
            Route::post('/update/{id}', [ModulesController::class, 'update'])->name('update')->middleware('checkpermission');
            Route::post('/view/{id}', [ModulesController::class, 'view'])->name('view')->middleware('checkpermission');
            Route::get('/delete/{id}', [ModulesController::class, 'delete'])->name('delete')->middleware('checkpermission');
            Route::post('/isactive/{id}', [ModulesController::class, 'isactive'])->name('isactive')->middleware('checkpermission');
            Route::post('/applystatus', [ModulesController::class, 'applystatus'])->name('applystatus')->middleware('checkpermission');

            //Dependent-Dropdown
            Route::post('/childmenu', [ModulesController::class, 'childmenu'])->name('childmenu');
        });

        //Permission
        Route::prefix('permission')->name('permission.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index')->middleware('checkpermission');
            Route::post('/create', [PermissionController::class, 'create'])->name('create')->middleware('checkpermission');
            Route::post('/store', [PermissionController::class, 'store'])->name('store')->middleware('checkpermission');
            Route::post('/edit/{id}', [PermissionController::class, 'edit'])->name('edit')->middleware('checkpermission');
            Route::post('/update/{id}', [PermissionController::class, 'update'])->name('update')->middleware('checkpermission');
            Route::post('/view/{id}', [PermissionController::class, 'view'])->name('view')->middleware('checkpermission');
            Route::get('/delete/{id}', [PermissionController::class, 'delete'])->name('delete')->middleware('checkpermission');
            Route::post('/isactive/{id}', [PermissionController::class, 'isactive'])->name('isactive')->middleware('checkpermission');
            Route::post('/applystatus', [PermissionController::class, 'applystatus'])->name('applystatus')->middleware('checkpermission');
        });

        //Role
        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index')->middleware('checkpermission');
            Route::post('/create', [RoleController::class, 'create'])->name('create')->middleware('checkpermission');
            Route::post('/store', [RoleController::class, 'store'])->name('store')->middleware('checkpermission');
            Route::post('/edit/{id}', [RoleController::class, 'edit'])->name('edit')->middleware('checkpermission');
            Route::post('/update/{id}', [RoleController::class, 'update'])->name('update')->middleware('checkpermission');
            Route::post('/view/{id}', [RoleController::class, 'view'])->name('view')->middleware('checkpermission');
            Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('delete')->middleware('checkpermission');
            Route::post('/isactive/{id}', [RoleController::class, 'isactive'])->name('isactive')->middleware('checkpermission');
            Route::post('/applystatus', [RoleController::class, 'applystatus'])->name('applystatus')->middleware('checkpermission');
            Route::get('/access/{id}', [RoleController::class, 'access'])->name('access')->middleware('checkpermission');
            Route::post('/accessupdate/{id}', [RoleController::class, 'accessupdate'])->name('accessupdate');
        });

        //Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index')->middleware('checkpermission');
            Route::post('/create', [SettingsController::class, 'create'])->name('create')->middleware('checkpermission');
            Route::post('/store', [SettingsController::class, 'store'])->name('store')->middleware('checkpermission');
            Route::post('/edit/{id}', [SettingsController::class, 'edit'])->name('edit')->middleware('checkpermission');
            Route::post('/update/{id}', [SettingsController::class, 'update'])->name('update')->middleware('checkpermission');
            Route::post('/view/{id}', [SettingsController::class, 'view'])->name('view')->middleware('checkpermission');
            Route::get('/delete/{id}', [SettingsController::class, 'delete'])->name('delete')->middleware('checkpermission');
            Route::post('/isactive/{id}', [SettingsController::class, 'isactive'])->name('isactive')->middleware('checkpermission');
            Route::post('/applystatus', [SettingsController::class, 'applystatus'])->name('applystatus')->middleware('checkpermission');
        });

        //Custom Page
        Route::prefix('custompages')->name('custompages.')->group(function () {
            Route::get('/', [CustompagesController::class, 'index'])->name('index')->middleware('checkpermission');
            Route::post('/create', [CustompagesController::class, 'create'])->name('create')->middleware('checkpermission');
            Route::post('/store', [CustompagesController::class, 'store'])->name('store')->middleware('checkpermission');
            Route::post('/edit/{id}', [CustompagesController::class, 'edit'])->name('edit')->middleware('checkpermission');
            Route::post('/update/{id}', [CustompagesController::class, 'update'])->name('update')->middleware('checkpermission');
            Route::post('/view/{id}', [CustompagesController::class, 'view'])->name('view')->middleware('checkpermission');
            Route::get('/delete/{id}', [CustompagesController::class, 'delete'])->name('delete')->middleware('checkpermission');
            Route::post('/isactive/{id}', [CustompagesController::class, 'isactive'])->name('isactive')->middleware('checkpermission');
            Route::post('/applystatus', [CustompagesController::class, 'applystatus'])->name('applystatus')->middleware('checkpermission');
        });

        //Email Templates
        Route::prefix('emailtemplates')->name('emailtemplates.')->group(function () {
            Route::get('/', [EmailtemplatesController::class, 'index'])->name('index')->middleware('checkpermission');
            Route::post('/create', [EmailtemplatesController::class, 'create'])->name('create')->middleware('checkpermission');
            Route::post('/store', [EmailtemplatesController::class, 'store'])->name('store')->middleware('checkpermission');
            Route::post('/edit/{id}', [EmailtemplatesController::class, 'edit'])->name('edit')->middleware('checkpermission');
            Route::post('/update/{id}', [EmailtemplatesController::class, 'update'])->name('update')->middleware('checkpermission');
            Route::post('/view/{id}', [EmailtemplatesController::class, 'view'])->name('view')->middleware('checkpermission');
            Route::get('/delete/{id}', [EmailtemplatesController::class, 'delete'])->name('delete')->middleware('checkpermission');
            Route::post('/isactive/{id}', [EmailtemplatesController::class, 'isactive'])->name('isactive')->middleware('checkpermission');
            Route::post('/applystatus', [EmailtemplatesController::class, 'applystatus'])->name('applystatus')->middleware('checkpermission');
        });

        //User
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index')->middleware('checkpermission');
            Route::post('/create', [UserController::class, 'create'])->name('create')->middleware('checkpermission');
            Route::post('/store', [UserController::class, 'store'])->name('store')->middleware('checkpermission');
            Route::post('/edit/{id}', [UserController::class, 'edit'])->name('edit')->middleware('checkpermission');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('update')->middleware('checkpermission');
            Route::post('/view/{id}', [UserController::class, 'view'])->name('view')->middleware('checkpermission');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete')->middleware('checkpermission');
            Route::post('/isactive/{id}', [UserController::class, 'isactive'])->name('isactive')->middleware('checkpermission');
            Route::post('/applystatus', [UserController::class, 'applystatus'])->name('applystatus')->middleware('checkpermission');
            Route::post('/changepassword/{id}', [UserController::class, 'changepassword'])->name('changepassword')->middleware('checkpermission');
            Route::post('/changepasswordupdate/{id}', [UserController::class, 'changepasswordupdate'])->name('changepasswordupdate');
        });
    });
});

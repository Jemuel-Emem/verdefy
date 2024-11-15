<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\UnreadMessageController;

// Inside your route or controller method where you render the view
$unreadMessageController = new UnreadMessageController();
$unreadMessageCount = $unreadMessageController->getUnreadMessageCount(request());
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/darbs', function () {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin-dashboard');
        } else {
            return redirect()->route('user-dashboard');
        }
    })->name('userdashboard');
});

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/ds', function () {
        return view('admin.main');
    })->name('admin-dashboard');

    Route::get('/addproduct', function () {
        return view('admin.products');
    })->name('products');

    Route::get('/dilverysched', function () {
        return view('admin.dileverysched');
    })->name('dileverysched');

    Route::get('/order', function () {
        return view('admin.order');
    })->name('order');

    Route::get('/customers', function () {
        return view('admin.customers');
    })->name('customers');

    Route::get('/customize', function () {
        return view('admin.customize');
    })->name('customizes');
});

Route::prefix('user')->middleware('user')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.index');
    })->name('user-dashboard');

    Route::get('/products', function () {
        return view('user.products');
    })->name('prod');

    Route::get('/carts', function () {
        return view('user.cart');
    })->name('cart');

    Route::get('/myorder', function () {
        return view('user.myorder');
    })->name('myorder');

    Route::get('/customize', function () {
        return view('user.customize');
    })->name('customize');

    Route::get('/contactus', function () {
        return view('user.contactus');
    })->name('contactus');

    Route::get('/aboutus', function () {
        return view('user.about');
    })->name('about');

    Route::get('/termsandcondition', function () {
        return view('user.agreement');
    })->name('terms');

});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    Route::group(['middleware' => ['web', 'auth']], function () {
        Route::get('/chatify/messenger', 'ChatifyController@index')->name('chatify.messenger');

        Route::post('/chatify/messages', 'ChatifyController@sendMessage')->name('chatify.messages.send');
        Route::get('/chatify/messages/fetch', 'ChatifyController@fetchMessages')->name('chatify.messages.fetch');
        Route::get('/chatify/messages/search', 'ChatifyController@searchMessages')->name('chatify.messages.search');

        Route::post('/chatify/attachments', 'ChatifyController@uploadAttachment')->name('chatify.attachments.upload');
        Route::get('/chatify/attachments/download/{attachment}', 'ChatifyController@downloadAttachment')->name('chatify.attachments.download');

        Route::get('/chatify/notifications/fetch', 'ChatifyController@fetchNotifications')->name('chatify.notifications.fetch');
        Route::post('/chatify/notifications/mark-as-read', 'ChatifyController@markNotificationsAsRead')->name('chatify.notifications.mark-as-read');
    });

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
require __DIR__.'/auth.php';

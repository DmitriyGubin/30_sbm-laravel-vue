<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminkaController;
use App\Models\Role;


use App\Models\User;
use App\Models\Order;

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

Route::get('/', [MainController::class, 'Main_Page']);

Route::post('/rent-form/', [MainController::class, 'Send_Rent_Form']);

Route::post('/call-order-form/', [MainController::class, 'Call_Order_Mail']);

Route::get('/registration/', [MainController::class, 'Registr_Page']);//для заказчика регистрация

Route::get('/reg_manager/', [MainController::class, 'Registr_Page_Manager']);//для менеджера регистрация

Route::get('/reg_provider/', [MainController::class, 'Registr_Page_Provider']);//для поставщика регистрация

Route::post('/registr/', [MainController::class, 'Registration']);

Route::post('/go_out/', [MainController::class, 'Go_Out']);

Route::get('/auth/', [MainController::class, 'Auth_Page']);

Route::post('/auth_user/', [MainController::class, 'Auth_User']);

Route::post('/check_this_cod/', [MainController::class, 'Check_Watsapp_Cod']);

Route::post('/update_this_cod/', [MainController::class, 'Update_Watsapp_Cod']);

Route::post('/tech_sect_list/', [MainController::class, 'Tech_Sect_List']);

Route::post('/tech_sub_sect_list/', [MainController::class, 'Tech_Sub_Sect_List']);

/***********админка**********/
Route::get('/manager_office/', [AdminkaController::class, 'Мanager_Page']) -> middleware('auth') -> middleware('check.manager');

//поставщик
Route::get('/provider_office/', [AdminkaController::class, 'Provider_Page']) -> middleware('auth') -> middleware('check.provider');

//заказчик
Route::get('/customer_office/', [AdminkaController::class, 'Customer_Page']) -> middleware('auth') -> middleware('check.customer');

Route::get('/admin_office/', [AdminkaController::class, 'Admin_Page']) -> middleware('auth') -> middleware('check.admin');

Route::post('/get_roles/', [AdminkaController::class, 'Get_Roles']) -> middleware('auth') -> middleware('check.admin');

Route::post('/delete_user/', [AdminkaController::class, 'Delete_User']) -> middleware('auth') -> middleware('check.admin');

Route::post('/save_user/', [AdminkaController::class, 'Save_User']) -> middleware('auth');

Route::post('/statuses/', [AdminkaController::class, 'Statuses']) -> middleware('auth');

Route::post('/cur_user/', [AdminkaController::class, 'Cur_User']) -> middleware('auth');

Route::post('/customer_orders/', [AdminkaController::class, 'Customer_Orders']) -> middleware('auth') -> middleware('check.customer');

Route::post('/save_order/', [AdminkaController::class, 'Save_Order']) -> middleware('auth');

Route::post('/change_order_status/', [AdminkaController::class, 'Change_Order_Status']) -> middleware('auth');

Route::post('/delete_order/', [AdminkaController::class, 'Delete_Order']) -> middleware('auth');

Route::get('/new_orders/', [AdminkaController::class, 'New_Orders']) -> middleware('auth') -> middleware('check.manager');

Route::post('/take_order/', [AdminkaController::class, 'Take_Order']) -> middleware('auth') -> middleware('check.manager');

Route::post('/refuse_order/', [AdminkaController::class, 'Refuse_Order']) -> middleware('auth') -> middleware('check.manager');

Route::get('/my_orders/', [AdminkaController::class, 'My_Orders']) -> middleware('auth') -> middleware('check.manager');

Route::get('/close_orders/', [AdminkaController::class, 'Close_Orders']) -> middleware('auth') -> middleware('check.manager');

Route::post('/recvizits/', [AdminkaController::class, 'All_Rekv']) -> middleware('auth') -> middleware('check.customer');

Route::post('/add_rekv/', [AdminkaController::class, 'Add_Rekv']) -> middleware('auth') -> middleware('check.customer');

Route::post('/delete_rekv/', [AdminkaController::class, 'Delete_Recv']) -> middleware('auth') -> middleware('check.customer');

Route::post('/update_rekv/', [AdminkaController::class, 'Update_Recv']) -> middleware('auth');

Route::post('/find_supplier/', [AdminkaController::class, 'Find_Supplier']) -> middleware('auth') -> middleware('check.manager');

Route::post('/get_providers/', [AdminkaController::class, 'Get_Providers']) -> middleware('auth') -> middleware('check.manager');

Route::post('/get_provider_orders/', [AdminkaController::class, 'Get_Provider_Orders']) -> middleware('auth') -> middleware('check.provider');

Route::post('/get_archive_orders/', [AdminkaController::class, 'Get_Archive_Orders']) -> middleware('auth') -> middleware('check.provider');

Route::post('/take_order_provider/', [AdminkaController::class, 'Take_Order_Provider']) -> middleware('auth') -> middleware('check.provider');

Route::post('/return_to_work/', [AdminkaController::class, 'Return_To_Work']) -> middleware('auth') -> middleware('check.provider');

Route::post('/delete_order_provider/', [AdminkaController::class, 'Delete_Order_Provider']) -> middleware('auth') -> middleware('check.provider');

Route::post('/auto_send_provider/', [AdminkaController::class, 'Auto_Send_Provider']) -> middleware('auth') -> middleware('check.manager');

Route::post('/get_techs/', [AdminkaController::class, 'Get_Techs']) -> middleware('auth') -> middleware('check.provider');

Route::get('/statistics_orders/', [AdminkaController::class, 'Statistics_Orders']) -> middleware('auth') -> middleware('check.admin');

Route::post('/get_first_manager/', [AdminkaController::class, 'Get_First_Manager']) -> middleware('auth') -> middleware('check.provider');

Route::get('/get_orders_status/', [AdminkaController::class, 'Get_Orders_Status']) -> middleware('auth') -> middleware('check.admin');

Route::get('/get_users_status/', [AdminkaController::class, 'Get_Users_Status']) -> middleware('auth') -> middleware('check.admin');
/***********админка**********/

// use App\Models\Statistics_order;
// Route::get('/testic/', function(){
//     $test = Statistics_order::all();
//     return $test;
// });

Route::get('/test/', [MainController::class, 'Test_Page']);
Route::post('/file/', [MainController::class, 'Save_File']);




<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Status;
use App\Models\Order;
use App\Models\Detail;
use App\Models\Provider_order;
use App\Models\Technic;
use App\Models\Provider_tech;
use App\Models\Statistics_order;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;
use App\Libraries\Crest;//для отправки лидов в битрикс 24


class AdminkaController extends Controller
{
    private $img_path_doc = '/storage/img/recviz';//путь сохранения, удаления, обновления реквизитов (скрытый)
    private $per_page = 5;//количество заказов на страницу (пагинация)

    public function Мanager_Page()
    {
        return view('adminka.manager_page');
    }

    public function Provider_Page()
    {
        return view('adminka.provider_page');
    }

    public function Customer_Page()
    {
        return view('adminka.customer_page');
    }

    public function Admin_Page()
    {
        return view('adminka.admin_page');
    }

    public function Get_Roles()
    {
        $role = Role::where('id', '!=', 1) -> get();
        return $role;
    }

    public function Delete_User(Request $request)
    {
        $id = $request->id_user;
        User::destroy($id);

        return response()->json([
            'id'=>$id
        ]);
    }

    public function Save_User(Request $request)
    {
        $id = $request -> id;
        $user = User::find($id);
        $user -> activity = $request -> activity;
        $status = true;
        if(isset($request -> name))
        {
            $user_phone = User::where('phone', $request->phone)->where('id', '!=', $id)->first();
            if($user_phone == null)
            {
                $status = false;//норм
                $user -> name = $request -> name;
                $user -> phone = $request -> phone;
            }
        }
        $user->save();

        return response()->json([
            'status'=> $status
        ]);
    }

    public function Delete_Order(Request $request)
    {
        $id = $request->id;
        Order::destroy($id);

        return response()->json([
            'status'=>'yes'
        ]);
    }

    public function Save_Order(Request $request)
    {
        $order = Order::find($request -> id);
        $order -> tech = trim($request -> tech);
        $order -> date = $request -> date;
        $order -> time = $request -> time;
        $order -> interval = trim($request -> interval);
        $order -> where = trim($request -> where);
        $order -> money = $request -> money;
        $order -> detail_id = $request -> detail_id;
        $order -> job = trim($request -> job);
        $order -> price = trim($request -> price);
        $order -> price_provider = trim($request -> price_provider);
        $order -> money_provider = $request -> money_provider;
        $order -> save();

        if($request -> detail == 'yes')
        {
            $detail = Detail::find($request -> detail_id);
            $detail -> name = $request -> name;
            $detail -> inn = $request -> inn;
            $detail -> kpp = $request -> kpp;
            $detail -> bik = $request -> bik;
            $detail -> check = $request -> check;
            $detail -> bank_name = $request -> bank_name;
            $detail -> save();
        }

        return response()->json([
            'status'=> 'yes'
        ]);
    }

    public function Change_Order_Status(Request $request)
    {
        $order = Order::find($request -> id);
        $order -> status_id = $request -> status_idd;
        $order -> save();

        return response()->json([
            'status'=> 'yes'
        ]);
    }

    public function Statuses()
    {
        $statuses = Status::all();
        return $statuses;
    }

    public function Cur_User()//получение заказов авторизованного пользователя
    {
        $user = Auth::user();
        return $user;
    }

    public function All_Rekv()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $cur_detail_id = $user->cur_detail_id;
        $rekv = Detail::where('user_id', $user_id)->orderBy('id', 'desc')->get();
    
        return response()->json([
            'data'=> $rekv,
            'cur_recv_id'=> $cur_detail_id
        ]);
    }

    public function New_Orders()
    {
        $orders = Order::with(['user','detail','provider'])->whereNull('manager_id')->where('status_id', 1)->orderBy('id', 'desc') -> paginate($this->per_page);
        return $orders;
    }

    public function My_Orders()
    {
        $id_user = Auth::user()->id;
        $orders = Order::with(['user','detail','provider'])->where('manager_id', $id_user)->where('status_id', 1)-> orderBy('id', 'desc') -> paginate($this->per_page);
       
        return $orders;
    }

    public function Close_Orders()
    {
        $id_user = Auth::user()->id;
        $orders = Order::with(['user','detail','provider'])->where('manager_id', $id_user)->where('status_id', 2)->orderBy('id', 'desc') -> paginate($this->per_page);
        return $orders;
    }

    public function Take_Order(Request $request)
    {
        $id_user = Auth::user()->id;
        $order = Order::find($request -> id_order);
        $order -> manager_id =  $id_user;
        $order -> save();

        return response()->json([
            'status'=> 'yes'
        ]);
    }

    public function Refuse_Order(Request $request)
    {
        $order = Order::find($request -> id_order);
        $order -> manager_id = null;
        $order -> save();

        return response()->json([
            'status'=> 'yes'
        ]);
    }

    public function Add_Rekv(Request $request)
    {
        $error = '';
        $id = '';
        $cur_rekv = false;
        $inn_check = Detail::where('inn', trim($request->inn))->first();
        if($inn_check != null)
        {
            $error='Такой инн уже есть!';
        }

        if($error == '')
        {
            $user = Auth::user();
            $id_user = $user -> id;
            $rekv = new Detail;
            $rekv->name = $request->name;
            $rekv->inn = $request->inn;
            $rekv->kpp = $request->kpp;
            $rekv->bik = $request->bik;
            $rekv->check = $request->check;
            $rekv->bank_name = $request->bank_name;
            $rekv->user_id = $id_user;
            
            $file_recv = $request -> file('file');
            if($file_recv != '')
            {
                $imageName = $request -> file_name;
                $file_recv->move(base_path(config('global.path_doc').($this->img_path_doc)), $imageName);
                $rekv->file_name = $imageName;
            }
            $rekv->save();
            $id = $rekv->id;

            if($user->cur_detail_id == null)
            {
                $user->cur_detail_id = $id;
                $user->save();
                $cur_rekv = true;
            }
        }
    
        return response()->json([
            'error'=> $error,
            'id'=>$id,
            'cur_rekv'=>$cur_rekv
        ]);
    }

    public function Update_Recv(Request $request)
    {
        $error = '';
        $id = $request->id;
        $inn_check = Detail::where('inn', trim($request->inn))->where('id', '!=' ,$id)->first();
        if($inn_check != null)
        {
            $error='Такой инн уже есть!';
        }

        if($error == '')
        {
            $rekv = Detail::where('id', $id)->first();

            $name = $request->name;
            if($name != 'null')
            {
                $rekv->name = $name;
            }

            $inn = $request->inn;
            if($inn != 'null')
            {
                $rekv->inn = $inn;
            }

            $kpp = $request->kpp;
            if($kpp != 'null')
            {
                $rekv->kpp = $kpp;
            }

            $bik = $request->bik;
            if($bik != 'null')
            {
                $rekv->bik = $bik;
            }

            $check = $request->check;
            if($check != 'null')
            {
                $rekv->check = $check;
            }

            $bank = $request->bank_name;
            if($bank != 'null')
            {
                $rekv->bank_name =  $bank;
            }
             
            $file_recv = $request -> file('file');
            if($file_recv != '')
            {
                $old_file_name = $rekv->file_name;
                if($old_file_name != null)
                {
                    $file = base_path(config('global.path_doc').($this->img_path_doc).'/'.$old_file_name);
                    if(file_exists($file))
                    {
                        unlink($file);
                    }
                }
                $imageName = $request -> file_name;
                $file_recv->move(base_path(config('global.path_doc').($this->img_path_doc)), $imageName);
                $rekv->file_name = $imageName;
            }
            $rekv->save();

            $cur_detail_id = $request -> cur_detail_id;
            $user = Auth::user();
            $user -> cur_detail_id = $cur_detail_id;
            $user->save();
        }
    
        return response()->json([
            'error'=> $error
        ]);
    }

    public function Delete_Recv(Request $request)
    {
        Detail::destroy($request->idd);
        $name = $request->img;//удаление файла
        if($name != null)
        {
            $file = base_path(config('global.path_doc').($this->img_path_doc).'/'.$name);
            if(file_exists($file))
            {
                unlink($file);
            }
        }

        return response()->json([
            'status'=>'yes'
        ]);
    }

    public function Customer_Orders()
    {
        $user_id = Auth::user()->id;
        $orders = Order::with(['manager'])->where('user_id', $user_id)->orderBy('id', 'desc') -> get();
        return $orders;
    }

    private function Find_Supplier_Common($data)
    {
        $class = new MainController;
        $id_order = $data['id'];
        $manager_id = $data['manager_id'];
        $text = 'Ваш заказ № '.$id_order.' принят и мы уже ищем Вам технику';
        $status = $class -> Send_Watsapp_Mess($data['phone_client'], $text);
        if($status)
        {
            $order = Order::find($id_order);
            $order -> find_supplier = 1;
            $order->save();

            /***заполнение таблицы***/
            $result = [];
            foreach($data['phones'] as $item)
            {
                $result[] = ['user_id' => $item['id_prov'], 
                             'order_id' => $id_order,
                             'status_id' => 1,
                             'manager_id' => $manager_id
                            ];
            }
            Provider_order::insert($result);
            /***заполнение таблицы***/

            /***рассылка поставщикам***/
            $mess = "Новая заявка на:\n".$data['tech']."\nДата:\n".$data['date']."\nВремя:\n".$data['time']."\nКоличество часов:\n".$data['interval']."\nСтоимость:\n".$data['price_provider']."\nНомер заказа: ".$id_order;
            foreach($data['phones'] as $item)
            {
                 $result = $class -> Send_Watsapp_Mess($item['phone'], $mess);
                 sleep(1);
            }
            /***рассылка поставщикам***/
        }
        return $status;
    }

    public function Find_Supplier(Request $request)
    {
        $data = [
            'id' => $request->id,
            'manager_id' => $request->manager_id,
            'phone_client' => $request->phone_client,
            'phones' => $request->phones,
            'tech' => $request->tech,
            'date' => $request->date,
            'time' => $request->time,
            'interval' => $request->interval,
            'price_provider' => $request->price_provider
        ];
        $status = $this -> Find_Supplier_Common($data);
        return $status;
    }

    public function Get_Providers()
    {
        //$providers = User::where('role_id', 3) -> get();
        $providers = Provider_tech::with(['provider','tech'])->get();
        return $providers;
    }

    public function Get_Provider_Orders()
    {
        $user_id = Auth::user()->id;
        $orders = Provider_order::with(['order','manager','providerr'])->where('user_id', $user_id)->where('status_id', 1)->orderBy('order_id', 'desc') -> get();
        return $orders;
    }

    public function Get_Archive_Orders()
    {
        $user_id = Auth::user()->id;
        $orders = Provider_order::with(['order','manager','providerr'])->where('user_id', $user_id)->where('status_id', 3)->orderBy('order_id', 'desc') -> get();
        return $orders;
    }

    public function Take_Order_Provider(Request $request)
    {
        $user_id = Auth::user()->id;
        //в архив для текущего пользователя
        Provider_order::where('order_id', $request->order_id)->where('user_id', $user_id)->update([
            'status_id' => 3
        ]);
        //закрыть для других
        Provider_order::where('order_id', $request->order_id)->where('user_id', '!=', $user_id)->update([
            'status_id' => 2
        ]);

        Order::where('id', $request->order_id)->update([
            'provider_id' => $user_id
        ]);

        $text = 'Нашёлся поставщик техники на заказ № '.$request->order_id. ".\nИмя: ".$request->name_prov.".\nТелефон".$request->phone_prov;
        $status = (new MainController) -> Send_Watsapp_Mess($request->phone_manager, $text);

        //отправка лида в битрикс24
        $fields_mass = [
            'TITLE' => "Нашёлся поставщик техники",
            'UF_CRM_1654176337' => $request->tech,
            'UF_CRM_1735190111' => $request->date,
            'UF_CRM_1735190758' => $request->time,
            'UF_CRM_1735190861' => $request->interval,
            'UF_CRM_1735190985' => $request->where,
            'UF_CRM_1735191113' => $request->price_provider,
            'UF_CRM_1735191172' => $request->money_provider,
            'NAME' => $request->name_prov,
            'UF_CRM_1735200241' => $request->phone_prov,
            'ASSIGNED_BY_ID' => $this->Make_Responsible_ID($request->phone_manager)
        ];
        $this -> Send_Lead_To_Bitrix($fields_mass);
    }

    private function Send_Lead_To_Bitrix($fields_mass)
    {
        $result = Crest::call(
            'crm.lead.add',
            [
               'fields' => $fields_mass
            ]
        );
    }

    private function Get_Bitrix_Users($start_from)
    {
        $result = Crest::call(
            'user.get',
            [
                "start" => $start_from
            ]
        );
        return $result;
    }

    private function Phone_Converter($phone)
    {
        $phone = str_replace('+', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);
        $phone = mb_substr($phone, 1);//8 или 7 вначале
    
        return $phone;
    }

    private function Make_Responsible_ID($manager_phone)//назначение ответственного за лид
    {
        $manager_phone = $this->Phone_Converter($manager_phone);
        $next = 0;
        $response_id = 1;//если не нашли, то Павел ответственный
        while(true)
        {
            $users = $this->Get_Bitrix_Users($next);
            $vals = $users['result'];
            
            foreach($vals as $value)
            {
                if(isset($value['WORK_PHONE']))
                {
                    $phone_one = $value['WORK_PHONE'];
                    if($phone_one != '')
                    {
                        $phone_one = $this->Phone_Converter($phone_one);
                        if($phone_one == $manager_phone)
                        {
                            $response_id = $value['ID'];
                            break;
                        }
                    }
                }
                
                if(isset($value['PERSONAL_MOBILE']))
                {
                    $phone_two = $value['PERSONAL_MOBILE'];
                    if($phone_two != '')
                    {
                        $phone_two = $this->Phone_Converter($phone_two);
                        if($phone_two == $manager_phone)
                        {
                            $response_id = $value['ID'];
                            break;
                        }
                    }
                } 
            }

            if(isset($users['next']))
            {
                $next = $users['next'];
            }
            else
            {
                break;
            }

            if($response_id != 1) break;
        }

        return $response_id;
    }

    public function Return_To_Work(Request $request)//возвращает в работу для всех поставщиков
    {
        Provider_order::where('order_id', $request->order_id)->update([
            'status_id' => 1
        ]);

        Order::where('id', $request->order_id)->update([
            'provider_id' => NULL
        ]);
    }

    public function Delete_Order_Provider(Request $request)
    {
        $id = $request->id_record;
        Provider_order::destroy($id);
    }

    public function Auto_Send_Provider(Request $request)
    {
        $Prov_tech = Provider_tech::with(['provider','tech'])->get();
        if(count($Prov_tech) == 0)
        {
            return 'no';
        }
        else
        {
            $name_tech = $request -> name;
            $phones = [];
            foreach($Prov_tech as $prov_item)
            {
                $tech_item = $prov_item['tech'];
                $name = $tech_item['type'];
                $one = $tech_item['char_one'];
                $two = $tech_item['char_two'];
                $three = $tech_item['char_three'];
                if($one != '')
                {
                    $name = $name.'; '.$one;
                }
                if($two != '')
                {
                    $name = $name.'; '.$two;
                }
                if($three != '')
                {
                    $name = $name.'; '.$three;
                }

                if($name_tech == $name)
                {
                    $phones[] = [
                        'id_prov' => $prov_item['provider']['id'],
                        'phone' => $prov_item['provider']['phone']
                    ];
                }
            }

            if(count($phones) == 0)
            {
                return 'no';
            }
            else
            {
                $data = [
                    'id' => $request->id,
                    'manager_id' => $request->manager_id,
                    'phone_client' => $request->phone_client,
                    'phones' => $phones,
                    'tech' => $request->tech,
                    'date' => $request->date,
                    'time' => $request->time,
                    'interval' => $request->interval,
                    'price_provider' => $request->price_provider
                ];
                $status = $this -> Find_Supplier_Common($data);
                return $status;
            }
        }
    }

    public function Get_Techs()
    {
        $provider = Auth::user();
        $prov_id = $provider->id;
        $techs = Provider_tech::with(['tech']) -> where('provider_id', $prov_id) -> get();
        return $techs;
    }

    public function Statistics_Orders()
    {
        $stat = Statistics_order::orderBy('quantity', 'desc')->paginate(3);
        return $stat;
    }

    public function Get_First_Manager()
    {
        $manager = User::where('role_id', 2)->first();
        return $manager;
    }

    public function Get_Orders_Status(Request $request)
    {
        //user ---> заказчик
        $orders = Order::with(['manager','user','detail','provider'])->where('status_id', $request->status)->orderBy('id', 'desc') -> paginate($this->per_page);
        return $orders;
    }

    public function Get_Users_Status(Request $request)
    {
        $users = User::where('role_id', $request->status)->orderBy('id', 'desc') -> paginate($this->per_page);
        return $users;
    }
}

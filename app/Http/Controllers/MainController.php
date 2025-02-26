<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Avto;
use App\Models\Codd;
use App\Models\Order;
use App\Models\Detail;
use App\Models\Technic;
use App\Models\Statistics_order;

class MainController extends Controller
{
    private $mail_to = 'testgubin@mail.ru';
    //'wwwfrolof@yandex.ru
    private $mail_from = 'cq44491@vh440.timeweb.ru';

    /*wazzup api*/
    private  $channelId = '****************';
    private $apiKey = '****************';
    private $url_wazz = 'https://api.wazzup24.com/v3/message';
    /*wazzup api*/

    private $img_path = 'img';//путь сохранения картинок 
    private $img_path_doc = '/storage/img/recviz';//путь сохранения реквизитов (скрытый)

    public function Main_Page() 
    {
        $chek_auth = Auth::check();
        if($chek_auth)
        {
            $user = Auth::user();
            $user_id = $user->id;
            $last_order = Order::where('user_id', $user_id)->orderBy('id', 'desc')->first();
            $cur_rekv = $user -> cur_detail_id;
            $role = $user->role_id;
        }
        else
        {
            $last_order = null;
            $cur_rekv = null;
            $role = null;
        }

        return view('main.main_page',['chek_auth' => $chek_auth, 
            'order' => $last_order,
            'recv'  => $cur_rekv,
            'role' => $role
        ]);
    }

    public function Call_Order_Mail(Request $request)
    {
        require_once base_path("vendor/autoload.php");
        
        $mail = new PHPMailer(true);

        $mail->CharSet = "UTF-8";
        $mail->From = $this -> mail_from;
        $mail->AddAddress($this -> mail_to);
        $mail->IsHTML(true);

        $mail->Subject  =  "Заявка на заказ звонка";
        $mail->Body     =  "Имя: ".$request->name." <br>".
        "Телефон: ".$request->phone." <br>".
        "Страница отправки: ".$_SERVER['HTTP_REFERER']." <br>";

        $result = false;
        //if ($mail->send())
        if(true)//заглушка
        {
            $result = true;
        }

        return response()->json([
            'status'=>$result
        ]);
    }

    private function Send_Mail_Rent_Form($data)
    {
        require_once base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        $mail->From = $this -> mail_from;
        $mail->AddAddress($this -> mail_to);
        $mail->IsHTML(true);

        $mail->Subject  =  "Форма аренды CБМ";
        $mail->Body     =  "Какая техника: ".$data['tech']." <br>".
        "Когда едем: ".$data['when']." <br>".
        "Ко скольки едем: ".$data['time']." <br>".
        "На сколько едем: ".$data['interval']." <br>".
        "Куда едем: ".$data['where']." <br>".
        "Что делаем: ".$data['job']." <br>".
        "Какой расчёт: ".$data['money']." <br>".
        "Ваш телефон: ".$data['phone']." <br>".
        "Желаемая стоимость: ".$data['price']." <br>".
        "Страница отправки: ".$_SERVER['HTTP_REFERER']." <br>";

        // if($_FILES['file']['name'] != '')//фото работы
        // {
        //     $mail->addAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
        // }

        // if($_FILES['file_rekv']['name'] != '')
        // {
        //     $mail->addAttachment($_FILES['file_rekv']['tmp_name'], $_FILES['file_rekv']['name']);
        // }

        $result = false;
        //if ($mail->send())
        if(true)//заглушка
        {
            $result = true;
        }

        return $result;
    }

    private function Make_Statistics($tech)
    {
        $tech = trim(mb_strtolower($tech));
        $similar = Statistics_order::where('tech_name', $tech)->first();
        if($similar == null)
        {
            $new_tech = new Statistics_order;
            $new_tech->tech_name = $tech;
            $new_tech->quantity = 1;
            $new_tech->save();
        }
        else
        {
            $quant = ($similar->quantity) + 1;
            $similar->quantity = $quant;
            $similar->save();
        }
    }

    public function Send_Rent_Form(Request $request) 
    {
        $result = true;

        if(Auth::check())
        {
            $cur_user = Auth::user();
            $phone = $cur_user->phone;
            $rekv_id = $cur_user->cur_detail_id;
        }
        else
        {
            $phone = $request->phone;
        }
        
        //автоматическая регистрация или авторизация
        $id_user = '';
        $auth_reg = '';
        $role = '';

        if(!Auth::check())
        {
            $user = User::where('phone', $phone)->first();
            if($user == null)
            {
                $auth_reg = 'registr';
                $role = 4;
            }
            else
            {
                $id_user = $user -> id;
                $auth_reg = 'auth';
            }
            $cod = $this -> Save_Secret_Cod();
            $wazz_status = $this -> Send_Watsapp_Mess($phone,'Код подтверждения: '.$cod);
        }
        else
        {
            $order = new Order;
            $order->tech = $request->tech;
            $order->date = $request->when;
            $order->time = $request->time;
            $order->interval = $request->interval;
            $order->where = $request->where;
            $order->job = $request->job;
            $order->money = $request->money;
            $order->user_id = $cur_user->id;
            $order->status_id = 1;
            $order->price = $request->price;
            
            $file = $request->file('file');
            if($file != '')
            {
                $imageName = time().'_img.'.$file->extension();
                $file->move(public_path($this->img_path), $imageName);
                $order->photo_name = $imageName;
            }

            $file_recv = $request -> file('file_rekv');
            if($file_recv != '')
            {
                $recv = new Detail;
                $recv -> user_id = $cur_user->id;
                $imageName = time().'_'.$file_recv->getClientOriginalName();
                $file_recv->move(base_path(config('global.path_doc').($this->img_path_doc)), $imageName);
                $recv -> file_name = $imageName;
                $recv->save();
                $order -> detail_id = $recv -> id;
                $cur_user -> cur_detail_id = $recv -> id;
                $cur_user->save();
            }
            else
            {
                $order->detail_id = $rekv_id;
            }

            $order->save();

            //статистика
            $this->Make_Statistics($request->tech);

            $data = [
                'tech' => $request->tech,
                'when' => $request->when,
                'time' => $request->time,
                'interval' => $request->interval,
                'where' => $request->where,
                'job' => $request->job,
                'money' => $request->money,
                'price' => $request->price,
                'phone' => $phone
            ];
            $res_mail = $this -> Send_Mail_Rent_Form($data);
        }

        return response()->json([
            'status'=>$result,
            'fields'=>[
                'auth_reg'=>$auth_reg, 
                'name'=>'Ваше имя', 
                'phone' => $phone, 
                'role' => $role,
                'id_user' => $id_user
            ],
            'order'=>[
                'tech'=>$request->tech,
                'when'=>$request->when,
                'time'=>$request->time,
                'interval'=>$request->interval,
                'where'=>$request->where,
                'job'=>$request->job,
                'money'=>$request->money,
                'price'=>$request->price
            ]
        ]);
    }

    public function Registr_Page()
    {
        //для заказчиков
        return view('main.registr_page', ['id' => 4]);
    }

    public function Registr_Page_Manager()
    {
        //для менеджеров
        return view('main.registr_page_manager', ['id' => 2]);
    }

    public function Registr_Page_Provider()
    {
        //для поставщика
        return view('main.registr_page_provider', ['id' => 3]);
    }

    private function Save_Secret_Cod()
    {
        $random = mt_rand(10001, 99999);
        $cod = Codd::all()->first();
        $cod -> cod = $random;
        $cod->save();
        return $random;
    }

    
    private function Phone_Converter($phone)
    {
        $phone = str_replace('+', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);
    
        return $phone;
    }

    public function Send_Watsapp_Mess($phone,$text)
    {
        $chatId = $this->Phone_Converter($phone);
        // $text = 'Код подтверждения: '.$cod;

        $channelId = $this -> channelId;
        $apiKey = $this -> apiKey;
        $chatType = 'whatsapp';
        $url = $this -> url_wazz;

        // Формируем тело запроса
        $post_data = json_encode(array(
            'channelId'=>$channelId,
            'chatId'=>$chatId,
            'chatType'=>$chatType,
            'text'=>$text
        ));
        
        $curl = curl_init(); // Используем curl для запроса к Wazzup API
        // Отправляем запрос в Wazzup
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer '.$apiKey,
        'Content-Type:application/json'
        ));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$post_data);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $server_response = curl_exec($curl);

        if($server_response === false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function Registration(Request $request)
    {
        $role = $request->status;
        $phone = $request->phone;
        $name = trim($request->name);

        $users = User::all();
        $flag = true;
        foreach ($users as $item) 
        {
            if(trim($item['phone']) == $phone)
            {
                $flag = false;
                break;
            }
        }
        
        $wazz_status = true;
        if($flag)
        {
            $cod = $this -> Save_Secret_Cod();
            $wazz_status = $this -> Send_Watsapp_Mess($phone, 'Код подтверждения: '.$cod);
        }
        
        return response()->json([
            'status'=>$flag,
            'fields'=>['phone'=>$phone, 'name'=>$name, 'role' => $role],
            'wazz_status'=>$wazz_status
          ]);
    }

    public function Check_Watsapp_Cod(Request $request)
    {
        $cod = Codd::all()->first()->cod;
        $boll = ($cod == trim($request -> cod));
        $role = $request -> role;
        $succes = '';

        $data = [
            'role' => $request -> role,
            'name' => $request -> name,
            'phone' => $request -> phone
        ];

        //$boll=true;//заглушка чтобы не проверять код, убрать
        if($boll)
        {
            if(($request -> type_form) == 'registr')
            {
                $id = $this -> Registr_After_Watsapp($data);
                $succes = 'Вы успешно зарегистрировались!';
            }

            if(($request -> type_form) == 'auth')
            {
                Auth::loginUsingId($request->id_user, $remember = true);
                $succes = 'Вы успешно авторизовались!';
                $id = $request->id_user;
            }

            if(($request -> tech) != '')//добавление заказа
            {
                $order = new Order;
                $order->tech = $request->tech;
                $order->date = $request->when;
                $order->time = $request->time;
                $order->interval = $request->interval;
                $order->where = $request->where;
                $order->job = $request->job;
                $order->money = $request->money;
                $order->user_id = $id;
                $order->status_id = 1;
                $order->price = $request->price;
                
                $file = $request->file('file');
                if($file != '')
                {
                    $imageName = time().'_img.'.$file->extension();
                    $file->move(public_path($this->img_path), $imageName);
                    $order->photo_name = $imageName;
                }

                $file_recv = $request -> file('file_rekv');
                if($file_recv != '')
                {
                    $recv = new Detail;
                    $recv -> user_id = $id;
                    $imageName = time().'_'.$file_recv->getClientOriginalName();
                    $file_recv->move(base_path(config('global.path_doc').($this->img_path_doc)), $imageName);
                    $recv -> file_name = $imageName;
                    $recv->save();
                    $order -> detail_id = $recv -> id;
                    $user = User::find($id);
                    $user -> cur_detail_id = $recv -> id;
                    $user->save();
                }
                else
                {
                    if(($request -> type_form) == 'auth')
                    {
                        $user = User::find($id);
                        $cur_detail_id = $user->cur_detail_id;
                        if($cur_detail_id != NULL)
                        {
                            $order -> detail_id = $cur_detail_id;
                        }
                    }
                }
                
                $order->save();
                //статистика
                $this->Make_Statistics($request->tech);

                $data_mail = [
                    'tech' => $request->tech,

                    'when' => $request->when,
                    'time' => $request->time,
                    'interval' => $request->interval,
                    'where' => $request->where,
                    'job' => $request->job,
                    'money' => $request->money,
                    'price' => $request->price,
                    'phone' => $request -> phone
                ];
                $res_mail = $this -> Send_Mail_Rent_Form($data_mail);
            }

        }

        return response()->json([
            'status'=> $boll,
            'role_id'=>$role,
            'succes'=>$succes
        ]);
    }

    private function Registr_After_Watsapp($data)
    {
        $userr = new User;
        $role = $data['role'];
        $userr->name = $data['name'];
        $userr->role_id = $role;
        $userr->phone = $data['phone'];
        $boll = ($role == 4 || $role == 3);
        if($boll)//для заказчика, поставщика
        {
            $userr->activity = 1;
        }
        else
        {
            //$userr->activity = 0;//менеджер
            $userr->activity = 1;//заглушка
        }

        $userr->save();
        //if($boll)
        if(true)//заглушка
        {
            Auth::login($userr);
        }

        return $userr->id;
    }

    public function Update_Watsapp_Cod(Request $request)
    {
        $cod = $this -> Save_Secret_Cod();
        $wazz_status = $this -> Send_Watsapp_Mess($request->phone,'Код подтверждения: '.$cod);
        
        return response()->json([
            'wazz_status'=>$wazz_status
        ]);
    }


    public function Go_Out()
    {
        Auth::logout();

        return response()->json([
            'success'=>'yes',
          ]);
    }

    public function Auth_Page()
    {
        return view('main.auth_page');
    }

    public function Auth_User(Request $request)
    {
        $flag = false;
        $phone = $request->phone;
        $text='';
        $wazz_status = true;
        $id_user = '';

        $user = User::where('phone', $phone)->first();
        if($user == null)
        {
            $text = 'Ошиблись в данных!';
        }
        else
        {
            if($user->activity == 0)
            {
                $text = 'Анкета на модерации!';
            }
            else
            {
                $id_user = $user -> id;
                $flag = true;
                $text = 'Подтвердите авторизацию!';

                $cod = $this -> Save_Secret_Cod();
                $wazz_status = $this -> Send_Watsapp_Mess($phone,'Код подтверждения: '.$cod);
                if(!$wazz_status)
                {
                    $text = 'Нет ответа от сервера!';
                }
            }
        }

        return response()->json([
            'status'=>$flag,
            'text'=>$text,
            'wazz_status'=>$wazz_status,
            'fields'=>['phone'=>$phone, 'id_user'=>$id_user]
          ]);
    }

    public function Tech_Sect_List()
    {
        $sects = Technic::orderBy('type', 'asc') -> pluck('type');
        $sects = json_decode($sects, true);
        $sects = array_unique($sects);
        return $sects;
    }

    public function Tech_Sub_Sect_List(Request $request)
    {
        $columns = $request -> columns;
        $names = $request -> names;
        $cur_column = $request -> cur_column;

        $query = Technic::query();
        $j=0;
        foreach($columns as $item)
        {
            if($item == $cur_column) break;
            if($names[$j] != 'пропуск')
            {
                if($names[$j] == null) $names[$j] = '';
                $query = $query->where($item, $names[$j]);
            }
            $j++;
        }

        $close = 'no';
        if($j == count($columns))
        {
            $close = 'yes';
            $data = $query -> get();
        }
        else
        {
            $data = $query -> orderBy($cur_column, 'asc') -> pluck($cur_column);
            $data = json_decode($data, true);
            $data = array_unique($data);
        }

        return response()->json([
            'sects'=>$data,
            'close'=>$close
        ]);
    }

    // тестирование

    public function Test_Page()
    {
        //return view('main.test_page');

        $cods = User::all();

        return $cods;
    }

    public function Save_File(Request $request)
    {
        $file = $request->file;
        $imageName = time().'_img.'.$file->extension();
        $file->move(public_path('img'), $imageName);
        $image = new Avto;
        $image->name = 'тест';
        $image->img_path = $imageName;
        $image->save();

        return response()->json([
            'status'=>'yes'
        ]);
    }
    // тестирование
}

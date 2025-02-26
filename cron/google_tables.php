<?php
error_reporting(E_ERROR | E_PARSE);
require_once 'vendor/autoload.php';
require_once 'connection.php';

/**чистка**/
$link -> query("TRUNCATE TABLE provider_teches");
$link -> query("DELETE FROM technics");
$link -> query("ALTER TABLE technics AUTO_INCREMENT = 1");//сброс первичного ключа
//$link -> query('DELETE FROM users WHERE role_id=3');
/**чистка**/

//exit();

function Filter($val)
{
    return trim(str_replace('\n', '', $val));
}

//+7(913) 450-2515
//+7(996) 382-0152
function Phone_Converter($val)
{
    $val = preg_replace('#[^0-9]+#', '', $val);
    $val = substr($val, 1);
    $res = '+7('.substr($val, 0, 3).') '.substr($val, 3, 3).'-'.substr($val, 6);
    return $res;
}

function Get_Users($link)
{
    $users = [];
    $query = "SELECT * FROM users";
    $alldata  = $link -> query($query);
    while($row=$alldata->fetch_assoc())
    {
        $users[] = $row;
    }
    return $users;
}

// Наш ключ доступа к сервисному аккаунту
//$googleAccountKeyFilePath = 'service_key.json';
$googleAccountKeyFilePath = __DIR__.'/service_key.json';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);

// Создаем новый клиент
$client = new Google_Client();

// Устанавливаем полномочия
$client->useApplicationDefaultCredentials();

// Добавляем область доступа к чтению, редактированию, созданию и удалению таблиц
$client->addScope('https://www.googleapis.com/auth/spreadsheets');

$service = new Google_Service_Sheets($client);

//ID таблицы
$spreadsheetId = '********************';//берём из урл
$range = 'Прайс с поставщиками';//имя листа
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$vals_table = $response->values;

/*****************Заполнение таблицы техники*******/
$query_str = "INSERT INTO technics (type,name,char_one,char_two,char_three,price_nds,price_no_nds,min_hour) values ";

$phones = [];
$providers = [];

$j=0;
foreach($vals_table as $key => $value)
{
    if(($key != 0) && (strpos($value[0], '_no_this') == false) && ($value[0] != ''))//техника
    {
        $j++;
        $type = Filter($value[0]);
        $name = Filter($value[1]);
        $char_one = Filter($value[2]);
        $char_two = Filter($value[3]);
        $char_three = Filter($value[4]);
        $price_nds = Filter($value[5]);
        $price_no_nds = Filter($value[6]);
        $min_hour = Filter($value[9]);
        $query_str = $query_str."('$type','$name','$char_one','$char_two','$char_three','$price_nds','$price_no_nds','$min_hour'),";
    }
    if(($key != 0) && ($value[11] != ''))//поставщики телефоны
    {
        $phone = Phone_Converter($value[11]);
        $phones[] = $phone;
        $providers[] = [
            'name'=>Filter($value[10]),
            'phone'=>$phone
        ];
    }
}

$query_str[strlen($query_str) - 1] = ' ';
if($j != 0)
{
    $link -> query($query_str);
}

/*****************Заполнение таблицы техники*******/


/*****************Заполнение таблицы поставщиков*******/
$phones = array_unique($phones);

$uniq_proveders = [];
foreach($phones as $phone_item)
{
    foreach($providers as $prov_item)
    {
        if($prov_item['phone'] == $phone_item)
        {
            $name = $prov_item['name'];
            break;
        }
    }

    $uniq_proveders[] = [
        'name'=>$name,
        'phone'=>$phone_item
    ];
}

//заполняем поставщиков
if(count($uniq_proveders) != 0)
{
    $users = Get_Users($link);
    $users_phones = [];
    foreach($users as $us_item)
    {
        $users_phones[] = $us_item['phone'];
    }
    $query_str = "INSERT INTO users (name, role_id, phone, activity) values ";

    $role_id = 3;
    $activity = 1;
    $j = 0;
    foreach($uniq_proveders as $item)
    {
        if($item['name'] == '')
        {
            $name = 'поставщик';
        }
        else
        {
            $name = $item['name'];
        }
        $phone = $item['phone'];
        if(!in_array($phone, $users_phones))
        {
            $j++;
            $query_str = $query_str."('$name','$role_id','$phone','$activity'),";
        }
    }
    $query_str[strlen($query_str) - 1] = ' ';
    if($j != 0)
    {
        $link -> query($query_str);
    }
}

/*****************Заполнение таблицы поставщиков*******/

/*****************Заполнение таблицы техники-поставщиков*******/
$j=0;
if(count($uniq_proveders) != 0)
{
    $providerss = Get_Users($link);
    $query_str = "INSERT INTO provider_teches (provider_id,tech_id) values ";
    $id_tech=0;
    foreach($vals_table as $key => $value)
    {
        if(($key != 0) && (strpos($value[0], '_no_this') == false) && ($value[0] != ''))
        {
            $id_tech++;
            $phone = $value[11];
            if($phone != '')
            {
                $phone = Phone_Converter($phone);
                foreach($providerss as $prov_item)
                {
                    if($prov_item['phone'] == $phone)
                    {
                        $j++;
                        $prov_id = $prov_item['id'];
                        $query_str = $query_str."('$prov_id','$id_tech'),";
                        break;
                    }
                }
            }
        }
    }
    $query_str[strlen($query_str) - 1] = ' ';
    if($j != 0)
    {
        $link -> query($query_str);
    }
}

/*****************Заполнение таблицы техники-поставщиков*******/

echo '777';

?>













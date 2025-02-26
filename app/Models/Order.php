<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Detail;

class Order extends Model
{
    use HasFactory;

    public function user()
	{
        return $this->belongsTo(User::class,'user_id');
	}

    public function detail()
	{
        return $this->belongsTo(Detail::class,'detail_id');
	}

    //protected $with = ['manager'];//имена должны совпадать ??? ---- рекурсия

    public function manager()
	{
        return $this->belongsTo(User::class,'manager_id');
	}

    public function provider()
	{
        return $this->belongsTo(User::class,'provider_id');
	}
}

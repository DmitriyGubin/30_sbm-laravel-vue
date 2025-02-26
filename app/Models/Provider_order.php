<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class Provider_order extends Model
{
    use HasFactory;

    public function order()
	{
		return $this->belongsTo(Order::class, 'order_id');
	}

    public function manager()
	{
		return $this->belongsTo(User::class, 'manager_id');
	}

	public function providerr()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}

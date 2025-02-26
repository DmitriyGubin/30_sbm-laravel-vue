<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Technic;

class Provider_tech extends Model
{
    use HasFactory;

    public function provider()
	{
		return $this->belongsTo(User::class, 'provider_id');
	}

    public function tech()
	{
		return $this->belongsTo(Technic::class, 'tech_id');
	}
}

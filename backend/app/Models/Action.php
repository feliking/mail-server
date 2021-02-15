<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;
    public $timestamps = true;
	public $guarded = ['id'];

	protected $fillable = ['user_id', 'method', 'path', 'data', 'ip_address'];

	public function user() 
	{
		return $this->belongsTo(User::class);
	}
}

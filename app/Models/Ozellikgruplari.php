<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ozellikgruplari extends Model
{
	use HasFactory;

	protected $table = 'ozellikgruplari';

	protected $fillable = ['grupadi'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diller extends Model
{
	use HasFactory;

	protected $table = 'diller';

	protected $fillable = ['diladi', 'dilkodu'];
}

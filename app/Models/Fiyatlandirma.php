<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiyatlandirma extends Model
{
	use HasFactory;

	protected $table = 'fiyatlandirma';

	protected $fillable = ['sembol', 'durum'];
}

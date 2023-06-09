<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Emlaklar extends Model implements HasMedia
{
	use InteractsWithMedia;
	use HasFactory;

	protected $table = 'emlak';

	protected $fillable = [
		'grup_id',
		'tip_id',
		'ilantipi',
		'ilan_no',
		'il_id',
		'ilce_id',
		'semt_id',
		'mahalle_id',
		'koordinatlar',
		'gorseller',
		'durum',
	];

	protected $casts = [
		'koordinatlar' => 'array',
		'gorseller' => 'array',
	];

	public function grup()
	{
		return $this->belongsTo(Emlakgruplari::class, 'grup_id');
	}

	public function tip()
	{
		return $this->belongsTo(Emlaktipleri::class, 'tip_id');
	}

	public function detay()
	{
		return $this->hasMany(Emlakdetay::class, 'emlak_id');
	}

	public function ozellikler()
	{
		return $this->hasMany(Emlakozellikleri::class, 'emlak_id');
	}

	public function nitelikler()
	{
		return $this->hasMany(Emlaknitelikleri::class, 'emlak_id');
	}

	public function il()
	{
		return $this->belongsTo(Iller::class, 'il_id');
	}

	public function ilce()
	{
		return $this->belongsTo(Ilceler::class, 'ilce_id');
	}

	public function mahalle()
	{
		return $this->belongsTo(Mahalleler::class, 'mahalle_id');
	}
}

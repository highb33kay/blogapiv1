<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

	protected $keyType = 'uuid';
    public $incrementing = false;

	// post model
	protected $fillable = [
		'title',
		'content',
		'published_at',
	];

	public function user()
    {
        return $this->belongsTo(User::class);
    }
}

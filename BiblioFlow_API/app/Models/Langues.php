<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langues extends Model
{
    use HasFactory;

    protected $fillable = [
        'langue',
    ];

    public function Books () {
        return $this->hasMany(Books::class);
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'genre_id',
        'langue_id',
        'publication_date',
        'isbn',
        'nbr_pages',
        'description',
        'image',
        'pdf_file'
    ];

    public function authors () {
        return $this->belongsTo(Authors::class, "author_id");
    }

    public function genres () {
        return $this->belongsTo(Genres::class, "genre_id");
    }

    public function langues () {
        return $this->belongsTo(Langues::class, "langue_id");
    }

    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

}

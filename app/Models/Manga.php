<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;

class Manga extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'author_id', // Pastikan kolom ini sudah didaftarkan
        'volumes_owned', 
        'last_read_chapter', 
        'status', 
        'cover_image'
    ];

    // Relasi ke model Author
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Manga;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relasi ke Manga
    public function mangas()
    {
        return $this->hasMany(Manga::class);
    }
}
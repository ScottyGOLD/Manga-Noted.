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
    'author_id', 
    'volumes_owned', 
    'last_read_chapter', 
    'target_chapter', 
    'status', 
    'cover_image'];

    // Relasi ke model Author
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject', 'competence', 'class', 'semester', 'meet', 'description', 'image_banner'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

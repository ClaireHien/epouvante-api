<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fanzine extends Model {
    protected $fillable = ['name', 'number', 'image', 'description', 'pdf_path', 'price'];

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('status', 'purchased_at');
    }
}

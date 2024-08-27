<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'task',
        'status'
    ];

    public function getStatusAttribute() {
        return $this->attributes["status"] ? 'Complete' : 'Pending';
    }
}

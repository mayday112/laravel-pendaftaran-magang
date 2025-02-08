<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportWeek extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'deskripsi',
        'foto'
    ];

    public function internship(){
        return $this->belongsTo(Internship::class);
    }
}

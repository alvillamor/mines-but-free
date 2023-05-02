<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'avatar', 'bet', 'multiplier', 'cashout', 'status'
    ]; 

    public function getStatusColorAttribute()
    {
        return [
            'win' => 'green',            
            'lose' => 'red',
        ][$this->status] ?? 'house';
    }
}

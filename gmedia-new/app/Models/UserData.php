<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'user_data';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'firstname',
        'lastname', 
        'organization',
        'address',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
}

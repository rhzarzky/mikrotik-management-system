<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'routers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'address',
        'username', 
        'password',
        'routername',
        'logo',
        'background',
        'loginpage',
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

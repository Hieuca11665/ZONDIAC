<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Xóa bỏ Laravel\Sanctum\HasApiTokens

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Xóa bỏ HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'avatar',
        'username',
        'phone_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function khoaHocs()
    {
        return $this->hasMany(KhoaHoc::class);
    }
}

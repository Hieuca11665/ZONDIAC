<?php
// app/Models/KhoaHoc.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhoaHoc extends Model
{
    use HasFactory;

    protected $table = 'khoa_hocs';

    protected $fillable = [
        'name',
        'birthday',
        'province',
        'district',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

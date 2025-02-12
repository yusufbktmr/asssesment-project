<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, SoftDelete;

    protected $table = 'customers';

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
    ];

    protected $dates = [
        'since',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // İlişkiler
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}

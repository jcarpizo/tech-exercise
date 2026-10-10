<?php declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyValues extends Model
{
    use HasFactory;

    protected $fillable = ['key_name', 'key_value', 'timestamp_reference'];

    protected $hidden = ['id','created_at', 'updated_at'];
}

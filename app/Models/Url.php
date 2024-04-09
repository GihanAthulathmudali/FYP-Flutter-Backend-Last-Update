<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $table = 'ngrokpublicurlinsert'; // Replace 'your_table_name' with your desired table name

    protected $fillable = ['url'];
}

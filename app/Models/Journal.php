<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AbstractModel;

class Journal extends AbstractModel
{
    use HasFactory;

    protected $guarded = [];
}

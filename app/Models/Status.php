<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- 1. Importar esto

class Status extends Model
{
    use HasFactory; // <--- 2. Usar esto dentro de la clase
    protected $table = 'status';
    protected $fillable = [
        'status',
        'value'
    ];
    //con el fillable aquí , aseguras que unicamente sean modificados los campos que solo sean editables
}


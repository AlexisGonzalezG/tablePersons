<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    public function toArray($request)
    {
        // Aquí defines exactamente qué ve el Frontend
        return [
            'id'     => $this->id,
            'name' => $this->name, 
            'last_name' => $this->last_name, 
            'status' => $this->status,
            // Esto es algo que un 'select' no hace: formatear la fecha
            'registrado' => $this->created_at->diffForHumans() 
        ];
    }
}
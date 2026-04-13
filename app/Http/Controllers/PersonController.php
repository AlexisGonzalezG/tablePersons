<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Http\Resources\PersonResource;

class PersonController extends Controller
{
    public function insertPerson(Request $request)
    { 
        $person = new Person;
        $person->name = $request->name;
        $person->last_name = $request->last_name;
        $person->save();
 
        return response()->json(['message' => 'Person created successfully'], 201);//201 CREATED
    }

    public function updatePerson(Request $request, $id)
    { 
        $person = Person::find($id);

        if (!$person) {
            return response()->json(['message' => 'Person not found'], 404);
        }

        // Laravel cruza el $request->all() con el $fillable del modelo.
        // Lo que no esté en el $fillable, simplemente lo ignora.
        $person->fill($request->all());// fill() solo prepara los datos en el objeto, pero NO toca la base de datos aún.
    
        // 2. ¿Hay cambios pendientes de guardar?
        if ($person->isDirty()) {
            $person->save();
            return response()->json([
                'message' => 'Changes detected and saved!',
                'data' => $person
            ], 200);
        }

        // 3. Si llega aquí, es porque el JSON era idéntico a la DB 
        return response()->json([
            'message' => 'No changes detected',
            'data' => $person
        ], 200);
    }

    public function deletePerson($id) // Recibimos el ID como un número/string simple
    { 
        // 1. Buscamos manualmente
        $person = Person::find($id);

        // 2. Si no existe, mandamos NUESTRO JSON personalizado
        if (!$person) {
            return response()->json([
                'status' => 'error',
                'message' => 'Person not found'
            ], 404);
        }

        // 3. Si existe, lo borramos
        $person->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Person deleted successfully'
        ], 200);
    }

    public function getAllPersons(Request $request)
    {
        // 1. Iniciamos una "Query" sin ejecutarla aún
        $query = Person::query()->select('id', 'name', 'last_name', 'status' , 'created_at');

        // 2. Filtro por Nombre (si el usuario lo envía)
        // Usamos 'when' para que solo aplique el filtro si hay algo escrito
        $query->when($request->name, function ($q, $name) {
            return $q->where('name', 'LIKE', "%{$name}%");
        });

        // 3. Filtro por Apellido
        $query->when($request->last_name, function ($q, $lastName) {
            return $q->where('last_name', 'LIKE', "%{$lastName}%");
        });

        // 4. Filtro por Estatus (exacto: 0 o 1)
        // Usamos filled() para asegurar que no sea nulo o vacío
        $query->when($request->filled('status'), function ($q) use ($request) {
            return $q->where('status', $request->status);
        });

        // 5. Ejecutamos la paginación final
        // Ahora sí usamos paginate() para tener el total de registros
        $people = $query->paginate(10);

        /*return response()->json([
            'status' => 'success',
            'data' => $people
        ], 200);*/

        return PersonResource::collection($people);
    }

    public function show(Person $person) {
        return new PersonResource($person); // para una persona
    }
}

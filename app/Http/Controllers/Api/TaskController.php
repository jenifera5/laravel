<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //Funció que torna les tasques que tenim
    public function index()
    {
        $tareas = Task::all();
        return $tareas;

    }
    //Funció que crea una nova tasca i la insereix a BBDD
    public function store(request $request){

        $request->validate([
            //Buscar a la documentació: Custom Validation Rules
            'name' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        $task = Task::create($data);
        $response = [
            'success' => true,
            'data' => $task,
            'message' => 'Tarea creada correctamente'
        ];
        return response()->json($response);

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            //Buscar a la documentació: Custom Validation Rules
            'name' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        $task = Task::find($id);
        $task->update($data);
        $response = [
            'success' => true,
            'data' => $task,
            'message' => 'Tarea actualizada correctamente'
        ];
        return response()->json($response);
    }

}

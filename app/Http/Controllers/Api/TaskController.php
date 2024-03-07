<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Symfony\Contracts\Service\Attribute\Required;

class TaskController extends Controller
{
    public function index()
    {
        $tareas = Task::all();
        return $tareas;
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'Required|max:10',
                            'description'=>'required'
    ]);
        $data = $request->all();
        $task = Task ::create($data);
       
        $response = [
            'success'=> true,
            'message'=>'la tarea se ha creado correctamente',
            'data'=> $task
        ];
        return response()->json();
    }
    public function update($id, Request $request)
    {
        $request->validate(['name'=>'Required|max:10',
        'description'=>'required'
        ]);
        $data = $request->all();
        $task = Task::find($id);
        $task-> update($data);
        $response = [
            'success'=> true,
            'message'=>'la tarea se ha creado correctamente',
            'data'=> $task
        ];
        return response()->json();
        
    }
}

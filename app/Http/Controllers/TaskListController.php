<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\TaskList;
use DataTables;
use Auth;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('task_lists.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uniqueRule = Rule::unique('task_lists')->where(function ($query) use ($request){
            $query->where('title', $request->title);
            $query->where('uid', Auth::user()->id);
        });

        $validator = \Validator::make($request->all(),
            ["title" => [$uniqueRule]]
        );
        
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "error" => $validator->errors()->toArray()
            ]);
        }

        $task_list = new TaskList();
        $task_list->title = $request->title;
        $task_list->uid   = Auth::user()->id;
        $query = $task_list->save();

        if (!$query) {
            return response()->json([
                "status"  => false,
                "message" => 'Что-то пошло не так!'
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => 'Список задач успешно создан!'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $task_list_id = $request->id;

        $validator = \Validator::make($request->all(),
            ["title" => "required|unique:task_lists,title,".$task_list_id,]
        );

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "error" => $validator->errors()->toArray()
            ]);
        }

        $task_list = TaskList::find($task_list_id);
        $task_list->title = $request->title;
        $task_list->uid   = Auth::user()->id;
        $query = $task_list->save();

        if (!$query) {
            return response()->json([
                "status"  => false,
                "message" => 'Что-то пошло не так!'
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => 'Список задач успешно обновлен!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $query = TaskList::find($request->list_id)->delete();
        
        if (!$query) {
            return response()->json([
                "status" => false,
                "message" => 'Что-то пошло не так!'
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => 'Список задач успешно удален!'
        ]);
    }

    /**
     * Get task lists from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaskLists() 
    {
        $task_lists = TaskList::where('uid', Auth::id())->get();
        return DataTables::of($task_lists)
                ->editColumn('created_at', function ($task_lists) {
                    return date('d-m-Y H:i', $task_lists->created_at->timestamp);
                })
                ->addIndexColumn()
                ->addColumn('actions', function($row) {
                    return '<div class="btn-group">
                                <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="edit-list-btn">Изменить</button>
                                <button class="btn btn-sm btn-danger ml-1" data-id="'.$row['id'].'" id="delete-list-btn">Удалить</button>
                            </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
    }

    /**
     * Get task list details from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function getTaskListDetails(Request $request) 
    {
        $task_list = TaskList::find($request->list_id);
        return response()->json(
            ['details' => $task_list]
        );
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;
use DataTables;
use File;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                "title" => "required:tasks",
                'image' => "mimes:jpeg,png,jpg,gif,svg"
            ],
        );
        
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "error" => $validator->errors()->toArray()
            ]);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images'), $image_name);
        }

        $task = new Task();
        $task->title = $request->title;
        $task->task_list_id = $request->task_list_id;
        $task->image = isset($image_name) ? $image_name : '';
        $task->state = 0;
        $query = $task->save();

        // Закрепление тегов
        if (!empty($request->tags)) {
            $tags = $this->getTagsDetails($request->tags);
            $task->tags()->attach($tags);
        }

        if (!$query) {
            return response()->json([
                "status"  => false,
                "message" => 'Что-то пошло не так!'
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => 'Задача успешно создана!'
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
        $task_id = $request->id;

        $validator = \Validator::make($request->all(),
            [
                "title" => "required:tasks,title,".$task_id,
                'image' => "mimes:jpeg,png,jpg,gif,svg"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "error" => $validator->errors()->toArray()
            ]);
        }

        $task = Task::find($task_id);
        $task->title = $request->title;
        $task->state = 0;

        // Обновление изображения
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images'), $image_name);
            // Удаляем старое изображение
            if (File::exists(public_path('images/'.$task->image))){
                File::delete(public_path('images/'.$task->image));
            }
            $task->image = $image_name;
        } 

        // Закрепление тегов
        if (!empty($request->tags)) {
            $tags = $this->getTagsDetails($request->tags);
            $task->tags()->sync($tags);
        } else {
            $task->tags()->detach();
        }

        $query = $task->save();

        if (!$query) {
            return response()->json([
                "status"  => false,
                "message" => 'Что-то пошло не так!'
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => 'Задача успешно обновлена!'
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
        $task = Task::find($request->task_id);
        $task->tags()->detach();
        $query = $task->delete();
        
        if (!$query) {
            return response()->json([
                "status" => false,
                "message" => 'Что-то пошло не так!!'
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => 'Задача успешно удалена!'
        ]);
    }

    /**
     * Get tasks from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function getTasks(Request $request) 
    {
        $tasks = Task::where('task_list_id', $request->task_list_id)->get();
        return DataTables::of($tasks)
                ->editColumn('created_at', function ($task_lists) {
                    return date('d-m-Y H:i', $task_lists->created_at->timestamp);
                })
                ->addIndexColumn()
                ->addColumn('actions', function($row) {
                    return '<div class="btn-group">
                                <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="edit-task-btn">Изменить</button>
                                <button class="btn btn-sm btn-danger ml-1" data-id="'.$row['id'].'" id="delete-task-btn">Удалить</button>
                            </div>';
                })
                ->addColumn('file', function($row) {
                    if ($row['image'] == '') return '';
                    return '<img class="image-preview" width="100px" src="/images/'.$row['image'].'">';
                })
                ->addColumn('tags', function($row) {
                    $badges = '';
                    foreach($row['tags'] as $tag) {
                        $badges .= '<span class="badge badge-info ml-2">'.$tag->title.'</span>';
                    }
                    return $badges;
                })
                ->rawColumns(['actions', 'file', 'tags'])
                ->make(true);
    }

    /**
     * Get task details from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function getTaskDetails(Request $request) 
    {
        $tags = [];
        $task = Task::find($request->task_id);
        foreach ($task->tags as $tag) {
            $tags[] = $tag->title;
        }
        return response()->json(
            ['details' => $task, 'tags' => implode(',', $tags)]
        );
    }

    /**
     * Get tags details for sync.
     *
     * @string $tags
     * 
     * @return array
     */
    private function getTagsDetails($tags) {
        $tags_sync = [];
        $tags = explode(",", $tags);

        foreach ($tags as $title) {
            $tag = Tag::where("title" , '=', $title)->first();
            if (empty($tag)) {
                $tag = new Tag();
                $tag->title = $title;
                $tag->save();
            }
            $tags_sync[] = $tag->id;
        }

        return $tags_sync;
    }
}

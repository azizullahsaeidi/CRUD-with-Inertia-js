<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ToDo::with('user')->get();
        $today = date("Y-m-d");
        return inertia('todo/index', ['data' => $data,'today' => $today]);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'date' => ['required'],
            'note' => ['required'],
        ])->validate();
  
        auth()->user()->todos()->create([
            'note' => $request->note,
            'date' => $request->date,
            'hours' => $request->hours,
        ]);
  
        return redirect()->back()
                    ->with('message', 'Post Created Successfully.');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'date' => ['required'],
            'note' => ['required'],
            'hours' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            ToDo::find($request->input('id'))->update([
                'note' => $request->note,
                'date' => $request->date,
                'hours' => $request->hours,
                'is_completed' => $request->is_completed
            ]);
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            ToDo::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}

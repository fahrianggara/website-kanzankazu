<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TodoLists;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = TodoLists::where('user_id', Auth::id())
            ->orderBy('completed', 'asc')
            ->orderBy('sort', 'asc')->get();

        $output = '';

        if ($todos->count() > 0) {

            $output .= '<span class="titleTask"></span><span id="ul" class="titleCompleted d-none"></span> <ul class="todo-list" id="todoList">';

            foreach ($todos as $todo) {

                if ($todo->completed == true) {

                    $completed = '
                        <li class="mb-1 itemLists done" data-id="' . $todo->id . '">
                            <span class="handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>

                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="' . $todo->id . '" name="completed" id="checkList" checked>
                                <label for="checkList"></label>
                            </div>

                            <span id="titleTodo" class="text">' . $todo->title . '</span>

                            <div class="tools">
                                <a href="javascript:void(0)" data-id="' . $todo->id . '" class="del_btn">
                                    <i class="uil uil-trash" data-toggle="tooltip" data-placement="top" title="Hapus"></i>
                                </a>
                            </div>
                        </li>
                    ';
                } else {
                    $completed = '
                        <li class="mb-1 itemLists notDone" data-id="' . $todo->id . '">
                            <span class="handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>

                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="' . $todo->id . '" name="completed" id="checkList">
                                <label for="checkList"></label>
                            </div>

                            <span id="titleTodo" class="text" style="cursor:pointer;">' . $todo->title . '</span>

                            <div class="tools">
                                <a href="javascript:void(0)" data-id="' . $todo->id . '" class="edit_btn" >
                                    <i class="uil uil-pen" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                </a>
                                <a href="javascript:void(0)" data-id="' . $todo->id . '" class="del_btn" >
                                    <i class="uil uil-trash" data-toggle="tooltip" data-placement="top" title="Hapus"></i>
                                </a>
                            </div>
                        </li>
                    ';
                }

                $output .= '<span class="titleCompleted d-none"></span>' . $completed;
            }

            $output .= '</ul>';
        } else {
            $output .= '
                <ul class="todo-list">
                    <li>
                        <span class="text text-primary">Tugas belum dibuat.</span>
                    </li>
                </ul>
            ';
        }

        echo $output;
    }

    public function sort(Request $request)
    {
        $todos = TodoLists::where('user_id', Auth::id())->get();

        foreach ($todos as $todo) {

            $todo->timestamps = false;
            $id = $todo->id;

            foreach ($request->sort as $sort) {
                if ($sort['id'] == $id) {
                    $todo->update(array('sort' => $sort['position']));
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil menyimpan urutan.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:100',
            ],
            [
                'title.required' => 'Judul list harus diisi!',
                'title.max' => 'Judul maksimal 100 karakter!',
            ]
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validation->errors()->toArray(),
            ]);
        } else {
            $insert = TodoLists::create(
                [
                    'title' => $request->title,
                    'user_id' => Auth::id(),
                ]
            );

            if ($insert) {
                return response()->json([
                    'status' => 200,
                    'message' => 'List baru berhasil ditambahkan!'
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Terjadi kesalahan saat menambahkan list'
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TodoLists  $todoLists
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = TodoLists::where('id', $id)->where('user_id', Auth::id())->first();

        if ($todo) {
            return response()->json([
                'status' => 200,
                'data' => $todo,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Data List tidak ditemukan!',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoLists  $todoLists
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:100',
            ],
            [
                'title.required' => 'Judul list harus diisi!',
                'title.max' => 'Judul maksimal 100 karakter!',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->toArray(),
            ]);
        } else {
            $todo = TodoLists::where('id', $id)->where('user_id', Auth::id())->first();
            if ($todo) {

                $oldTitle = $request->oldTitle;
                $todo->title = $request->title;

                if ($todo->isDirty()) {

                    $todo->update();

                    if ($todo->wasChanged('title')) {
                        return response()->json([
                            'status' => 200,
                            // 'message' => 'Judul list "' . $oldTitle . '" berhasil diubah menjadi "' . $request->title . '".',
                            'message' => 'Judul list berhasil diubah.',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Tidak ada perubahan!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Terjadi kesalahan saat mengubah list'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoLists  $todoLists
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = TodoLists::find($id);
        if ($todo) {

            $todo->delete();

            return response()->json([
                'status' => 200,
                'message' => 'List berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Terjadi kesalahan saat menghapus list'
            ]);
        }
    }

    public function completed(Request $request, $id)
    {
        $todo = TodoLists::find($id);
        if ($todo) {
            if ($todo->completed == true) {
                $todo->update(array(
                    'completed' => false,
                    'completed_at' => null,
                ));

                return response()->json([
                    'status' => 200,
                    'message' => 'Hmm, tugas batal diselesaikan?'
                ]);
            } else {
                $todo->update(array(
                    'completed' => true,
                    'completed_at' => Carbon::now(),
                ));

                return response()->json([
                    'status' => 200,
                    'message' => 'Ntaps! List "' . $todo->title . '" telah diselesaikan!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Terjadi kesalahan saat meng-ceklis list'
            ]);
        }
    }
}

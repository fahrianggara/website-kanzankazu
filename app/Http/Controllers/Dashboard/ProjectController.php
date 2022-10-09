<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::id() == '2') {
            return view('dashboard.manage-users.profiles.portfolio.title-portfolio.index');
        } else {
            abort(404);
        }
    }

    public function fetch()
    {
        $projects = Project::all();
        $output = '';

        if ($projects->count() > 0) {
            $output .= '
            <table id="tableProject" class="table table-hover align-items-center overflow-hidden">
                <thead>
                    <tr>
                        <th>TITLE PROJECT</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
           ';
            foreach ($projects as $data) {
                $output .= '
                    <tr>
                        <td> ' . $data->title . ' </td>
                        <td>
                            <div class="btn-group dropleft">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </button>

                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-1">
                                    <button value="' . $data->id . '" class="edit_btn dropdown-item d-flex align-items-center">
                                        <i class="uil uil-pen text-warning"></i>
                                        <span class="ml-2">Edit Title Project</span>
                                    </button>
                                    <button value="' . $data->id . '" data-title="' . $data->title . '" class="del_btn dropdown-item d-flex align-items-center">
                                        <i class="uil uil-trash text-danger"></i>
                                        <span class="ml-2">Hapus Title Project</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                ';
            }
            $output .= '</tbody></table>';
        } else {
            $output .= '
                <div class="card-body">
                    <div class="text-center">
                        <p class="card-text">
                            <b>
                            Hmm.. sepertinya belum ada title project yang dibuat.
                            </b>
                        </p>
                    </div>
                </div>
            ';
        }

        echo $output;
    }

    public function select(Request $request)
    {
        $projects = [];
        if ($request->has('query')) {
            $projects = Project::select('id', 'title')->search($request->query)->get();
        } else {
            $projects = Project::select('id', 'title')->get();
        }

        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|alpha_spaces',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->errors()->toArray(),
            ]);
        } else {
            $project = Project::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'user_id' => Auth::id(),
            ]);

            if ($project) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Judul Portfolio ' . $request->title . ' berhasil ditambahkan',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Judul Portfolio gagal ditambahkan',
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);

        if ($project) {
            return response()->json([
                'status' => 200,
                'data' => $project,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Judul Portfolio tidak ditemukan',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|alpha_spaces',
            'slug' => 'required|unique:projects,slug,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->errors()->toArray(),
            ]);
        } else {
            try {
                if ($project) {
                    $project->title = $request->title;
                    $project->slug = $request->slug;

                    if ($project->isDirty()) {

                        $project->update();

                        return response()->json([
                            'status' => 200,
                            'message' => 'Judul Portfolio ' . $request->title . ' berhasil diperbarui',
                        ]);
                    } else {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Tidak ada perubahan',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Judul Portfolio tidak ditemukan',
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Error: ' . $th->getMessage(),
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        try {
            if ($project) {

                $useTitle = Portfolio::join('portfolio_project', 'portfolio_project.portfolio_id', '=', 'portfolios.id')
                    ->where('portfolio_project.project_id', $project->id)
                    ->get();

                if ($useTitle->count() > 0) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Judul Portfolio "' . $project->title . '" tidak dapat dihapus karena sedang digunakan!',
                    ]);
                } else {
                    $project->delete();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Judul Portfolio ' . $project->title . ' berhasil dihapus',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Judul Portfolio tidak ditemukan',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $th->getMessage(),
            ]);
        }
    }
}

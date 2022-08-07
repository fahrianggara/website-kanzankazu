<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProjectsPortfolio;
use App\Models\ProjectsTitlePortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProjectPortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.manage-users.profiles.portfolio.index', [
            'titles' => ProjectsTitlePortfolio::all(),
        ]);
    }

    public function fetch()
    {
        $projects = ProjectsPortfolio::where('user_id', Auth::id())->get();
        $output = '';

        if ($projects->count() > 0) {
            $output .= '
                <table id="tableProjects" class="table table-hover align-items-center overflow-hidden">
                    <thead>
                        <tr>
                            <th>Portfolio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
           ';
            foreach ($projects as $data) {

                if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $data->thumbnail)) {
                    $thumbnail = asset('vendor/dashboard/image/thumbnail-posts/' . $data->thumbnail);
                } else {
                    $thumbnail = asset('vendor/blog/img/default.png');
                }

                $output .= '
                <tr>
                    <td>
                        <a href="javascript:void(0)" class="d-flex align-items-center" style="cursor: default">
                            <img src="' . $thumbnail . '" width="60" class="avatar me-3">
                            <div class="d-block ml-3">
                                <span class="fw-bold name-user">' . $data->project_title . '</span>
                                <div class="small text-secondary">
                                        ' . substr($data->project_description, 0, 20) . '...
                                </div>
                            </div>
                        </a>
                    </td>
                    <td>
                        <div class="btn-group dropleft">
                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil uil-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-1">
                                <button value="' . $data->id . '" class="show_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-eye text-primary"></i>
                                    <span class="ml-2">Lihat Project</span>
                                </button>
                                <button value="' . $data->id . '" class="edit_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-pen text-warning"></i>
                                    <span class="ml-2">Edit Project</span>
                                </button>
                                <button value="' . $data->id . '" data-title="' . $data->project_title . '" class="del_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-trash text-danger"></i>
                                    <span class="ml-2">Hapus Project</span>
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
                        <b>Hmm.. sepertinya project portfolio belum dibuat</b>
                    </p>
                </div>
            </div>
            ';
        }
        echo $output;
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
            'language_title' => 'null',
            'project_title' => 'required',
            'thumbnail' => 'image|mimes:jpg,png,jpeg,gif|max:1024',
            'project_description' => 'nullable',
            'title_project' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->errors()->toArray(),
            ]);
        } else {
            try {
                if ($request->hasFile('thumbnail')) {
                    $path = 'vendor/dashboard/image/thumbnail-posts/';
                    $image = $request->file('thumbnail');
                    $newImage = uniqid('PortfolioIMG-') . '.' . $image->extension();
                    $image->move($path, $newImage);
                }

                $projectPortfolio = ProjectsPortfolio::create([
                    'language_title' => $request->language_title,
                    'project_title' => $request->project_title,
                    'thumbnail' => $newImage,
                    'project_description' => $request->project_description ?? $request->language_title,
                    'user_id' => Auth::id(),
                ]);
                $projectPortfolio->projectTitles()->attach($request->title_project);

                if ($projectPortfolio) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Project portfolio baru berhasil ditambahkan!'
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Gagal membuat Project portfolio!'
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Pesan: ' . $th->getMessage()
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectsPortfolio  $projectsPortfolio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = ProjectsPortfolio::where('id', $id)->first();
        if ($project) {
            return response()->json([
                'status' => 200,
                'data' => $project
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project portfolio tidak ditemukan!'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectsPortfolio  $projectsPortfolio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = ProjectsPortfolio::where('id', $id)->first();
        if ($project) {
            return response()->json([
                'status' => 200,
                'data' => $project
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project portfolio tidak ditemukan!'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectsPortfolio  $projectsPortfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = ProjectsPortfolio::find($id);

        $validator = Validator::make($request->all(), [
            'language_title' => 'required',
            'project_title' => 'required',
            'thumbnail' => 'image|mimes:jpg,png,jpeg,gif|max:1024',
            'project_description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->errors()->toArray()
            ]);
        } else {
            if ($project) {
                $project->language_title = $request->input('language_title');
                $project->project_title = $request->input('project_title');
                $project->project_description = $request->input('project_description');

                if ($request->hasFile('thumbnail')) {
                    $path = 'vendor/dashboard/image/thumbnail-posts/';
                    if (File::exists($path . $project->thumbnail)) {
                        File::delete($path . $project->thumbnail);
                    }
                    $image = $request->file('thumbnail');
                    $newImage = uniqid('PortfolioIMG-') . '.' . $image->extension();
                    $image->move($path, $newImage);

                    $project->thumbnail = $newImage;
                }

                if ($project->isDirty()) {

                    $project->update();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Project portfolio ' . $project->project_title . ' berhasil diubah!'
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Tidak ada perubahan data!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Project portfolio tidak ditemukan!'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectsPortfolio  $projectsPortfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = ProjectsPortfolio::find($id);
        if ($project) {
            $path = 'vendor/dashboard/image/thumbnail-posts/';
            if (File::exists($path . $project->thumbnail)) {
                File::delete($path . $project->thumbnail);
            }

            $project->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Project portfolio: ' . $project->project_title . ', berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project portfolio tidak ditemukan!'
            ]);
        }
    }

    public function fetchTitle()
    {
        $projectTitles = ProjectsTitlePortfolio::all();
        $output = '';

        if ($projectTitles->count() > 0) {
            $output .= '
            <table id="tableProjectTitle" class="table table-hover align-items-center overflow-hidden">
                <thead>
                    <tr>
                        <th>TITLE PROJECT</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
           ';
            foreach ($projectTitles as $data) {
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
                                        <span class="ml-2">Edit Tag</span>
                                    </button>
                                    <button value="' . $data->id . '" data-name="' . $data->title . '" class="del_btn dropdown-item d-flex align-items-center">
                                        <i class="uil uil-trash text-danger"></i>
                                        <span class="ml-2">Hapus Tag</span>
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

    public function storeTitle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|alpha_spaces',
            'slug' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->errors()->toArray()
            ]);
        } else {

            $insert = ProjectsTitlePortfolio::create([
                'title' => $request->title,
                'slug' => $request->slug,
            ]);

            if ($insert) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Title project ' . $request->title . ' berhasil ditambahkan!'
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Title project ' . $request->title . ' gagal ditambahkan!'
                ]);
            }
        }
    }

    public function selectTitle(Request $request)
    {
        $projectTitles = [];
        if ($request->has('q')) {
            $projectTitles = ProjectsTitlePortfolio::select('id', 'title')->search($request->q)->get();
        } else {
            $projectTitles = ProjectsTitlePortfolio::select('id', 'title')->get();
        }

        return response()->json($projectTitles);
    }
}

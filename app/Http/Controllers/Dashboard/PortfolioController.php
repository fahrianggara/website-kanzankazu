<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::id() == '2') {
            $projects = Project::all();
            return view('dashboard.manage-users.profiles.portfolio.index', [
                'projects' => $projects,
            ]);
        } else {
            abort(404);
        }

    }

    public function fetch()
    {
        $portfolios = Portfolio::where('user_id', Auth::id())->get();
        $output = '';

        if ($portfolios->count() > 0) {
            $output .= '
                <table id="tablePortfolio" class="table table-hover align-items-center overflow-hidden">
                    <thead>
                        <tr>
                            <th>Portfolio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
           ';
            foreach ($portfolios as $data) {

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
                                <span class="fw-bold name-user">' . $data->title . '</span>
                                <div class="small text-secondary">
                                        ' . substr($data->description, 0, 20) . '...
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
                                    <span class="ml-2">Lihat Portfolio</span>
                                </button>
                                <button value="' . $data->id . '" class="edit_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-pen text-warning"></i>
                                    <span class="ml-2">Edit Portfolio</span>
                                </button>
                                <button value="' . $data->id . '" data-title="' . $data->title . '" class="del_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-trash text-danger"></i>
                                    <span class="ml-2">Hapus Portfolio</span>
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
                        <b>Hmm.. sepertinya Portfolio belum dibuat</b>
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
            'title' => 'required',
            'thumbnail' => 'image|mimes:jpg,png,jpeg,gif|max:1024',
            'description' => 'nullable',
            'project' => 'required',
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

                $portfolio = Portfolio::create([
                    'title' => $request->title,
                    'thumbnail' => $newImage,
                    'description' => $request->description ?? $request->title,
                    'user_id' => Auth::id(),
                ]);

                $portfolio->projects()->attach($request->project, ['user_id' => Auth::id()]);

                if ($portfolio) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Portfolio baru berhasil ditambahkan!'
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Gagal membuat Portfolio!'
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
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portfolio = Portfolio::with('projects')->find($id);

        if ($portfolio) {
            return response()->json([
                'status' => 200,
                'data' => $portfolio
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
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portfolio = Portfolio::with('projects')->find($id);

        if ($portfolio) {
            return response()->json([
                'status' => 200,
                'data' => $portfolio,
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
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'thumbnail' => 'image|mimes:jpg,png,jpeg,gif|max:1024',
            'description' => 'nullable',
            'project' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->errors()->toArray(),
            ]);
        } else {
            try {
                if ($portfolio) {
                    if ($request->hasFile('thumbnail')) {
                        $path = 'vendor/dashboard/image/thumbnail-posts/';
                        if (File::exists($path . $portfolio->thumbnail)) {
                            File::delete($path . $portfolio->thumbnail);
                        }
                        $image = $request->file('thumbnail');
                        $newImage = uniqid('PortfolioIMG-') . '.' . $image->extension();
                        $image->move($path, $newImage);

                        $portfolio->thumbnail = $newImage;
                    }

                    $portfolio->title = $request->title;
                    $portfolio->description = $request->description;
                    $portfolio->projects()->syncWithPivotValues($request->project, ['user_id' => Auth::id()]);

                    $portfolio->update();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Portfolio ' . $portfolio->title . ' berhasil diubah!'
                    ]);

                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Portfolio tidak ditemukan!'
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portfolio = Portfolio::find($id);

        if ($portfolio) {
            $path = 'vendor/dashboard/image/thumbnail-posts/';
            if (File::exists($path . $portfolio->thumbnail)) {
                File::delete($path . $portfolio->thumbnail);
            }

            $portfolio->delete();
            $portfolio->projects()->detach();

            return response()->json([
                'status' => 200,
                'message' => 'Portfolio: ' . $portfolio->title . ', berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Portfolio tidak ditemukan!'
            ]);
        }

    }
}

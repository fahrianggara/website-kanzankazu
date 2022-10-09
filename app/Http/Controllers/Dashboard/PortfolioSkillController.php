<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PortfolioSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PortfolioSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::id() == '2') {
            return view('dashboard.manage-users.profiles.portfolio.skill.index');
        } else {
            abort(404);
        }
    }

    public function fetch()
    {
        $skills = PortfolioSkill::where('user_id', Auth::id())->get();
        $output = '';

        if ($skills->count() > 0) {
            $output .= '
            <table id="tableSkill" class="table table-hover align-items-center overflow-hidden">
                <thead>
                    <tr>
                        <th>Skill</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
           ';
            foreach ($skills as $data) {
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
                                        <span class="ml-2">Edit Skill</span>
                                    </button>
                                    <button value="' . $data->id . '" data-title="' . $data->title . '" class="del_btn dropdown-item d-flex align-items-center">
                                        <i class="uil uil-trash text-danger"></i>
                                        <span class="ml-2">Hapus Skill</span>
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
                            Hmm.. sepertinya belum ada skill yang dibuat.
                            </b>
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
            'title' => 'required|string',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->errors()->toArray(),
            ]);
        } else {
            $skill = PortfolioSkill::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'user_id' => Auth::id(),
            ]);

            if ($skill) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Skill ' . $request->title . ' berhasil ditambahkan',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Skill gagal ditambahkan',
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PortfolioSkill  $portfolioSkill
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $skill = PortfolioSkill::find($id);

        if ($skill) {
            return response()->json([
                'status' => 200,
                'data' => $skill,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Skill tidak ditemukan',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PortfolioSkill  $portfolioSkill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $skill = PortfolioSkill::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'slug' => 'required|unique:portfolio_skills,slug,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->errors()->toArray(),
            ]);
        } else {
            try {
                if ($skill) {
                    $skill->title = $request->title;
                    $skill->slug = $request->slug;

                    if ($skill->isDirty()) {

                        $skill->update();

                        return response()->json([
                            'status' => 200,
                            'message' => 'Skill ' . $request->title . ' berhasil diperbarui',
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
                        'message' => 'Skill tidak ditemukan',
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
     * @param  \App\Models\PortfolioSkill  $portfolioSkill
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skill = PortfolioSkill::find($id);

        try {
            if ($skill) {

                $skill->delete();

                return response()->json([
                    'status' => 200,
                    'message' => 'Skill ' . $skill->title . ' berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Skill tidak ditemukan',
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

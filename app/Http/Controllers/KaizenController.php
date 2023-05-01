<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Kaizen;
use App\Models\Status;
use App\Models\Category;
use App\Models\Signature;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \PDF;

class KaizenController extends Controller
{
    public function index()
    {
        $statusRejected = Status::where('name', 'Rejected')->first();
        if (Auth::user()->getAllPermissions()->map(
            function ($item) {
                return [
                    'name' => $item->name
                ];
            }
        )->contains('name', 'kaizen.secretary') && !Auth::user()->getAllPermissions()->map(
            function ($item) {
                return [
                    'name' => $item->name
                ];
            }
        )->contains('name', 'kaizen.pic')) {
            $kaizens = Kaizen::where('pic_id', '!=', null)->where('status_pic_id', '!=', $statusRejected->id)->when(request()->q, function ($kaizens) {
                $kaizens = $kaizens->where('no', 'like', '%' . request()->q . '%');
            })->with(['departement', 'category', 'statusPic', 'statusSecretary'])->latest()->paginate(10);
        } else {
            $kaizens = Kaizen::when(request()->q, function ($kaizens) {
                $kaizens = $kaizens->where('no', 'like', '%' . request()->q . '%');
            })->with(['departement', 'category', 'statusPic', 'statusSecretary'])->latest()->paginate(10);
        }

        return Inertia::render('Kaizen/Index', [
            'kaizens' => $kaizens,
        ]);
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $departements = Departement::select('id', 'name')->get();

        return Inertia::render('Kaizen/Create', [
            'categories' => $categories,
            'departements' => $departements,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'departement_id' => ['required', 'exists:departements,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description_old' => ['required', 'string'],
            'description_new' => ['required', 'string'],
            'image_old' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png', 'dimensions:min_width=5,min_height=5'],
            'image_new' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png', 'dimensions:min_width=5,min_height=5'],
            'benefit' => ['required', 'string'],
        ]);

        $year = date('Y');
        $month = date('m');

        $lastKaizen = Kaizen::whereYear('created_at', $year)->latest()->first();

        if ($lastKaizen) {
            $no = $lastKaizen->no;
            $no = explode('/', $no);
            $no = $no[0];
            $no = (int) $no;
            $no++;
            $no = str_pad($no, 4, '0', STR_PAD_LEFT) . '/' . number2Roman($month) . '/' . $year;
        } else {
            $no = '0001' . '/' . number2Roman($month) . '/' . $year;
        }

        if ($request->image_old) {
            $imageOld = $request->file('image_old');
            $imageOldName = 'KAIZEN' . date('YmdHis') . '-OLD-' . $imageOld->hashName();
            $imageOld->storeAs('public/kaizens', $imageOldName);
        } else {
            $imageOldName = null;
        }

        if ($request->image_new) {
            $imageNew = $request->file('image_new');
            $imageNewName = 'KAIZEN' . date('YmdHis') . '-NEW-' . $imageNew->hashName();
            $imageNew->storeAs('public/kaizens', $imageNewName);
        } else {
            $imageNewName = null;
        }

        $status = Status::where('name', 'Terkirim')->first();

        $kaizen = Kaizen::create([
            'no' => $no,
            'departement_id' => $request->departement_id,
            'category_id' => $request->category_id,
            'status_pic_id' => $status->id,
            'status_secretary_id' => $status->id,
            'name' => $request->name,
            'description_old' => $request->description_old,
            'description_new' => $request->description_new,
            'image_old' => $imageOldName,
            'image_new' => $imageNewName,
            'benefit' => $request->benefit
        ]);

        return to_route('kaizens.details', $kaizen->id)->with('success', true);
    }

    public function show(Kaizen $kaizen)
    {
        return Inertia::render('Kaizen/Show', [
            'kaizen' => $kaizen->load([
                'departement' => function ($query) {
                    $query->select('id', 'name');
                }, 'category' => function ($query) {
                    $query->select('id', 'name');
                }, 'statusPic' => function ($query) {
                    $query->select('id', 'name');
                }, 'statusSecretary' => function ($query) {
                    $query->select('id', 'name');
                },
            ]),
        ]);
    }

    public function showGuest(Kaizen $kaizen)
    {
        return Inertia::render('Kaizen/Detail', [
            'kaizen' => $kaizen->load([
                'departement' => function ($query) {
                    $query->select('id', 'name');
                }, 'category' => function ($query) {
                    $query->select('id', 'name');
                }, 'statusPic' => function ($query) {
                    $query->select('id', 'name');
                }, 'statusSecretary' => function ($query) {
                    $query->select('id', 'name');
                },
            ]),
        ]);
    }

    public function signPIC(Kaizen $kaizen)
    {
        $statuses = Status::all();
        return Inertia::render('Kaizen/SignPic', [
            'kaizen' => $kaizen->load([
                'departement' => function ($query) {
                    $query->select('id', 'name');
                }, 'category' => function ($query) {
                    $query->select('id', 'name');
                }, 'statusPic' => function ($query) {
                    $query->select('id', 'name');
                }, 'statusSecretary' => function ($query) {
                    $query->select('id', 'name');
                },
            ]),
            'statuses' => $statuses
        ]);
    }

    public function signSecretary(Kaizen $kaizen)
    {
        if ($kaizen->pic_id == null) {
            return redirect()->back()->with('error', 'Kaizen belum ditandatangani oleh PIC');
        }

        $statuses = Status::all();
        return Inertia::render('Kaizen/SignSecretary', [
            'kaizen' => $kaizen->load([
                'departement' => function ($query) {
                    $query->select('id', 'name');
                }, 'category' => function ($query) {
                    $query->select('id', 'name');
                }, 'statusPic' => function ($query) {
                    $query->select('id', 'name');
                }, 'statusSecretary' => function ($query) {
                    $query->select('id', 'name');
                },
            ]),
            'statuses' => $statuses
        ]);
    }

    public function updateSignPic(Kaizen $kaizen, Request $request)
    {
        $this->validate($request, [
            'review_pic' => ['required', 'string'],
            'point_pic' => ['required', 'numeric', 'integer', 'min:0', 'max:100'],
            'status_pic_id' => ['required', 'uuid', 'exists:statuses,id'],
        ]);

        DB::beginTransaction();
        try {
            if ($kaizen->pic_id) {
                $kaizen->update([
                    'review_pic' => $request->review_pic,
                    'point_pic' => $request->point_pic,
                    'status_pic_id' => $request->status_pic_id,
                ]);
            } else {
                $signature = Signature::create([
                    'user_id' => Auth::user()->id
                ]);

                $kaizen->update([
                    'review_pic' => $request->review_pic,
                    'point_pic' => $request->point_pic,
                    'status_pic_id' => $request->status_pic_id,
                    'pic_id' => $signature->id,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('kaizens.index')->with('success', 'Kaizen cheked successfully!');
    }

    public function updateSignSecretary(Kaizen $kaizen, Request $request)
    {
        if ($kaizen->pic_id == null) {
            return to_route('kaizens.index')->with('error', 'Kaizen belum ditandatangani oleh PIC');
        }

        $this->validate($request, [
            'review_secretary' => ['required', 'string'],
            'point_secretary' => ['required', 'numeric', 'integer', 'min:0', 'max:100'],
            'status_secretary_id' => ['required', 'exists:statuses,id'],
        ]);

        DB::beginTransaction();
        try {
            if ($kaizen->secretary_id) {
                $kaizen->update([
                    'review_secretary' => $request->review_secretary,
                    'point_secretary' => $request->point_secretary,
                    'status_secretary_id' => $request->status_secretary_id,
                ]);
            } else {
                $signature = Signature::create([
                    'user_id' => Auth::user()->id
                ]);

                $kaizen->update([
                    'review_secretary' => $request->review_secretary,
                    'point_secretary' => $request->point_secretary,
                    'status_secretary_id' => $request->status_secretary_id,
                    'secretary_id' => $signature->id,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('kaizens.index')->with('success', 'Kaizen cheked successfully!');
    }

    public function destroy(Kaizen $kaizen)
    {
        if ($kaizen->image_old) {
            Storage::disk('local')->delete('public/kaizens/' . $kaizen->image_old);
        }
        if ($kaizen->image_new) {
            Storage::disk('local')->delete('public/kaizens/' . $kaizen->image_new);
        }

        $kaizen->delete();

        return redirect()->route('kaizens.index')->with('success', 'Kaizen deleted successfully!');
    }

    public function printPDF(Kaizen $kaizen)
    {
        $categories = Category::select('id', 'name')->get();
        $pdf = PDF::loadView('exports.kaizen', ['kaizen' => $kaizen->load([
            'departement' => function ($query) {
                $query->select('id', 'name');
            }, 'category' => function ($query) {
                $query->select('id', 'name');
            }, 'statusPic' => function ($query) {
                $query->select('id', 'name', 'description');
            }, 'statusSecretary' => function ($query) {
                $query->select('id', 'name', 'description');
            }, 'pic' => function ($query) {
                $query->select('id', 'user_id')->with('user:id,name');
            }, 'sekretaris' => function ($query) {
                $query->select('id', 'user_id')->with('user:id,name');
            },
        ]), 'categories' => $categories]);
        return $pdf->download('kaizen-' . $kaizen->id . '.pdf');
    }
}

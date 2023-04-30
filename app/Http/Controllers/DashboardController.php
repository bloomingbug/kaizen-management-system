<?php

namespace App\Http\Controllers;

use App\Models\Kaizen;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'permission:dashboard.index|dashboard.summary_data|dashboard.kaizen_chart|dashboard.kaizen_category|dashboard.new_kaizen_table',
        ]);
    }

    public function __invoke(Request $request)
    {
        // Summary of Kaizen (PIC)
        $sumKaizenApproved = Kaizen::whereRelation('statusPic', 'name', 'Approved')->count();
        $sumKaizenRejected = Kaizen::whereRelation('statusPic', 'name', 'Rejected')->orWhereRelation('statusSecretary', 'name', 'Rejected')->count();
        $sumKaizenPending = Kaizen::whereRelation('statusPic', 'name', 'Pending')->orWhereRelation('statusSecretary', 'name', 'Pending')->count();
        $sumKaizenNewPic = Kaizen::whereRelation('statusPic', 'name', 'Terkirim')->count();
        $sumKaizenNewSecretary = Kaizen::whereRelation('statusSecretary', 'name', 'Terkirim')->WhereRelation('statusPic', 'name', 'Approved')->count();
        $sumKaizenThisMonth = Kaizen::whereMonth('created_at', date('m'))->count();
        $sumKaizenToday = Kaizen::whereMonth('created_at', date('m'))->whereDay('created_at', date('d'))->count();
        $sumKaizen = Kaizen::count();

        // Table Kaizen List
        $kaizensNew = Kaizen::with('statusPic', 'statusSecretary', 'category', 'departement')->latest()->limit(10)->get();

        // Kaizen Donut Chart (category, qty)
        $donut_kaizen = Kaizen::selectRaw('count(*) as count, category_id')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'status' => $item->category->name,
                    'count' => $item->count,
                ];
            });

        if (count($donut_kaizen)) {
            foreach ($donut_kaizen as $result) {
                $categoryDonut[] = $result['status'];
                $countDonut[] = $result['count'];
            }
        } else {
            $categoryDonut[] = "";
            $countDonut[] = "";
        }

        // LineChart Kaizen (date, qty) 30Day
        $line_kaizen = Kaizen::selectRaw('count(*) as count, DATE(created_at) as date')
            ->groupBy('date')
            ->limit(30)
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count,
                ];
            });

        if (count($line_kaizen)) {
            foreach ($line_kaizen as $result) {
                $dateLine[] = $result['date'];
                $countLine[] = $result['count'];
            }
        } else {
            $dateLine[] = "";
            $countLine[] = "";
        }

        return Inertia::render('Dashboard/Index', [
            'sumKaizenApproved' => $sumKaizenApproved,
            'sumKaizenRejected' => $sumKaizenRejected,
            'sumKaizenPending' => $sumKaizenPending,
            'sumKaizenNewSecretary' => $sumKaizenNewSecretary,
            'sumKaizenNewPic' => $sumKaizenNewPic,
            'sumKaizenThisMonth' => $sumKaizenThisMonth,
            'sumKaizenToday' => $sumKaizenToday,
            'sumKaizen' => $sumKaizen,
            'kaizensNew' => $kaizensNew,
            'categoryDonut' => $categoryDonut,
            'countDonut' => $countDonut,
            'dateLine' => $dateLine,
            'countLine' => $countLine,
        ]);
    }
}

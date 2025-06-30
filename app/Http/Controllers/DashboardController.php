<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index() {
        // Total persons
        $totalPersons = \App\Models\Person::count();

        // Age groups
        $ageGroups = [
            '18-30' => 0,
            '31-50' => 0,
            '51+' => 0,
        ];
        $now = now();
        $persons = \App\Models\Person::select('date_of_birth')->get();
        foreach ($persons as $p) {
            if (!$p->date_of_birth) continue;
            $age = $now->diffInYears(\Carbon\Carbon::parse($p->date_of_birth));
            if ($age >= 18 && $age <= 30) $ageGroups['18-30']++;
            elseif ($age >= 31 && $age <= 50) $ageGroups['31-50']++;
            elseif ($age >= 51) $ageGroups['51+']++;
        }

        // Birth month
        $birthMonthCounts = \App\Models\Person::selectRaw('MONTH(date_of_birth) as month, COUNT(*) as count')
            ->groupBy('month')->orderBy('month')->pluck('count', 'month')->toArray();

        // Religion
        $religionCounts = \App\Models\Person::selectRaw('religion_id, COUNT(*) as count')
            ->groupBy('religion_id')->pluck('count', 'religion_id')->toArray();
        $religionNames = \App\Models\Religion::whereIn('id', array_keys($religionCounts))->pluck('name', 'id')->toArray();
        $religionChart = [];
        foreach ($religionCounts as $rid => $count) {
            $religionChart[$religionNames[$rid] ?? 'Unknown'] = $count;
        }

        return view('dashboard', [
            'totalPersons' => $totalPersons,
            'ageGroups' => $ageGroups,
            'birthMonthCounts' => $birthMonthCounts,
            'religionChart' => $religionChart,
        ]);
    }

}

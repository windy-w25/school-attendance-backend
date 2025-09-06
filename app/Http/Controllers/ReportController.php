<?php
namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller {
    public function studentReport($studentId)
    {
        $student = Student::find($studentId);
        if (!$student) {
            return response()->json([
                'message' => 'No data available.'
            ], 404);
        }

        $rows = Attendance::where('student_id', $studentId)
            ->orderBy('date', 'desc')
            ->get(['date', 'status']);

        $total = $rows->count();
        $present = $rows->where('status', 'present')->count();
        $absent = $rows->where('status', 'absent')->count();

        return [
            'student' => $student,
            'records' => $rows,
            'summary' => [
                'total_days' => $total,
                'present'    => $present,
                'absent'     => $absent,
            ]
        ];
    }



    public function classReport(Request $r){
        $data = $r->validate([
            'class_name'=>'required|string',
            'month'=>'required|date_format:Y-m'
        ]);
        $start = Carbon::parse($data['month'].'-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $records = Attendance::with('student')
            ->where('class_name',$data['class_name'])
            ->whereBetween('date', [$start,$end])
            ->get();

        return $records->groupBy('student_id')->map(function($g){
            $present = $g->where('status','present')->count();
            $absent  = $g->where('status','absent')->count();
            return [
                'student'=>$g->first()->student->only(['id','name','class_name']),
                'present'=>$present,'absent'=>$absent,'total'=>$present+$absent
            ];
        })->values();
        

    }
}

<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AttendanceController extends Controller {
    public function studentsByClass($className){
        return Student::where('class_name',$className)->orderBy('name')->get();
    }

    public function classList(){
        $classes = Student::select('class_name')
            ->distinct()
            ->orderBy('class_name')
            ->get();

        return response()->json($classes);
    }

    public function markForClass(Request $r){
        $user = $r->user();
        abort_unless($user->role==='teacher', 403);

        $data = $r->validate([
            'class_name'=>'required|string',
            'date'=>'nullable|date',
            'marks'=>'required|array',
            'marks.*.student_id'=>'required|exists:students,id',
            'marks.*.status'=>'required|in:present,absent'
        ]);
        $date = $data['date'] ?? now()->toDateString();

        // Prevent teacher marking same class twice same day
        $already = Attendance::where('teacher_id',$user->id)
            ->where('class_name',$data['class_name'])
            ->whereDate('date',$date)
            ->exists();
        if ($already) {
            return response()->json(['message'=>'Already marked for this class today'], 422);
        }

        DB::transaction(function() use ($data,$date,$user){
            foreach($data['marks'] as $m){
                Attendance::updateOrCreate(
                    ['student_id'=>$m['student_id'], 'date'=>$date],
                    ['status'=>$m['status'], 'teacher_id'=>$user->id, 'class_name'=>$data['class_name']]
                );
            }
        });

        return response()->json(['message'=>'Attendance saved']);
    }
}

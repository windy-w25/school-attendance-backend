<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;

class AdminController extends Controller
{
 
    public function storeStudent(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'class_name' => 'required|string|max:255',
        ]);

        $student = Student::create($data);

        return response()->json($student, 201);
    }

    public function indexStudents()
    {
        return Student::orderBy('id')->orderBy('class_name')->get();
    }

    public function storeTeacher(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $teacher = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), 
            'role' => 'teacher',
        ]);

        return response()->json($teacher, 201);
    }

    public function indexTeachers()
    {
        return User::where('role', 'teacher')
            ->orderBy('id')
            ->get(['id','name','email','role']);
    }
}

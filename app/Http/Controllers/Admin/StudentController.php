<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function showByYear($yearId)
    {
        $year = Year::with('students')->findOrFail($yearId);
        $students = $year->students;

        return view('admin.users.student.index', compact('year', 'students'));
    }
}

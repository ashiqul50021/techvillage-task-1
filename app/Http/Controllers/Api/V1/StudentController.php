<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function studentId()
    {

        $studentIds = DB::table('results')
            ->select('student_id')
            ->where('subject', '=', 'English')
            ->groupBy('student_id')
            ->orderByDesc(DB::raw('MAX(mark)'))
            ->skip(2)
            ->take(1)
            ->pluck('student_id'); //

        return response()->json([
            'data' => $studentIds,

        ]);
    }
}
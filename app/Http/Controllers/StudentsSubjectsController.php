<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\StudentsSubjects;
use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentsSubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        $subjects = Courses::all();
        if ($subjects->count()==0){
            return redirect('/AddSubject')->with('message', 'Please add subject first.');
        }
        $title = "CreateAccount";
        return view('pages.AddStudentSubject')->with('title', $title)->with(compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);


        $department = Courses::where('name', $request->get('name'))->first()->department;
        $department_id = Courses::where('name', $request->get('name'))->first()->departments_id;


        $studentsubject = new StudentsSubjects([
            'name' => $request->get('name'),
            'students_id' => Auth::user()->id,
            'department' => $department,
            'departments_id' => $department_id,

        ]);

        $studentsubject->save();

        return redirect('/')->with('success', 'Subject has been created successfully!');
    }


}

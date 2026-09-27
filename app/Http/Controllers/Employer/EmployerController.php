<?php

namespace App\Http\Controllers\Employer;

use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobType; 
use App\Models\Skill; 

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employers = Employer::all();
        return view('employers.index', compact('employers'));     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills = Skill::all(); 
        $categories = Category::all(); $jobTypes = JobType::all(); 
        return view('employer.jobs.create', compact('categories','jobTypes','skills'));  
    }
}
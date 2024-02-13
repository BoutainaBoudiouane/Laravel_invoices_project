<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SectionsController extends Controller
{

 function __construct()
{
$this->middleware('permission:اضافة قسم', ['only' => ['store']]);
$this->middleware('permission:تعديل قسم', ['only' => ['update']]);
$this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
}
    public function index()
    {
        //get data
        $sections = sections::all();
        return view('sections.sections',["sections"=>$sections]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections',
            'description' => 'required',
        ],[
            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',
        ]);

            sections::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=>(Auth::user()->name),
            ]);
            session()->flash('Add','تم اضافة القسم بنجاح');
            return redirect('/sections');    
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sections $sections)
    {
        $id = $request->id;

        $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
            'description'  => 'required',
        ], [
            'section_name.required' => 'يرجى إدخال اسم القسم',
            'section_name.unique'   => 'اسم القسم مسجل مسبقًا',
            'description.required'  => 'يرجى إدخال البيان',
        ]);
    
        sections::find($id)->update([
            'section_name' => $request->section_name,
            'description'  => $request->description,
        ]);
    
        session()->flash('edit', 'تم تعديل القسم بنجاح');
        return redirect('/sections');
    }


    public function destroy(Request $request)
    {   
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SectionRequest;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::get();
        return view('sections.section')->with('sections',$sections);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $section_name = $request->section_name;
        $description = $request->description;


        $this->validate($request,[
        'section_name' => 'required|string|unique:sections,section_name|max:255',
        'description' => 'required',
    ]
);


         Section::create([

            'section_name'=>$section_name,
            'description' =>$description,
            'Created_by' => (Auth::user()->name)
        ]);

         session()->flash('add','تمت اضافة القسم بنجاح');

       

        return redirect()->back();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $section_name = $request->section_name;
        $description = $request->description;

                $this->validate($request,[
        'section_name' => 'required|string|max:255|unique:sections,section_name,'.$id,
        'description' => 'required',
    ]
);
       $section = Section::find($id);

       $section->update([

        'section_name' => $section_name,
        'description' => $description

       ]);

       session()->flash('edit','تم تعديل القسم بنجاح');         
       
       return redirect()->back();



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        Section::find($id)->delete();

        session()->flash('delete','تم حذف القسم بنجاح');

        return redirect()->back();
    }

  
}

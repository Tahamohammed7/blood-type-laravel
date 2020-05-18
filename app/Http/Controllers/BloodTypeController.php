<?php

namespace App\Http\Controllers;

use App\BloodType;
use Illuminate\Http\Request;

class BloodTypeController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:bloodtype-list|bloodtype-create|bloodtype-edit|bloodtype-delete', ['only' => ['index','store']]);
        $this->middleware('permission:bloodtype-create', ['only' => ['create','store']]);
        $this->middleware('permission:bloodtype-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bloodtype-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bloodTypes = BloodType::all();
        return view('admin.bloodTypes.index',compact('bloodTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bloodTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:blood_types'
        ];
        $message = [
          'name.required' => 'Name Is Required'
        ];

        $this->validate($request,$rules,$message);

        $bloodTypes = BloodType::create($request->all());

        flash()->success('success');
        return redirect(route('bloodTypes.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $bloodType = BloodType::findOrfail($id);
       return view('admin.bloodTypes.edit',compact('bloodType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bloodType = BloodType::findOrfail($id);
        $bloodType->update($request->all());
        flash()->success('Updated');
        return redirect(route('bloodTypes.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bloodType = BloodType::findOrfail($id);
        $bloodType->delete();
        flash()->success('Deleted');
        return redirect(route('bloodTypes.index'));
    }
}

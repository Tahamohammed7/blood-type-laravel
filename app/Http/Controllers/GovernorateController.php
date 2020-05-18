<?php

namespace App\Http\Controllers;

use App\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:governorate-list|governorate-create|governorate-edit|governorate-delete', ['only' => ['index','store']]);
        $this->middleware('permission:governorate-create', ['only' => ['create','store']]);
        $this->middleware('permission:governorate-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:governorate-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $governorates = Governorate::paginate(10);
        return view('admin.governorates.index',compact('governorates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.governorates.create');
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
            'name' => 'required|unique:governortes'
        ];
        $message = [
         'name.required' => 'Name Is Required'
        ];
       $this->validate($request,$rules,$message);

//       $governorate = new Governorate;
//       $governorate->name = $request->input('name');
//       $governorate->save();
        $governorate = Governorate::create($request->all());
        flash()->success('success');
       return redirect(route('governorate.index'));
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
        $governorate = Governorate::findOrfail($id);
        return view('admin.governorates.edit',compact('governorate'));
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
        $governorate = Governorate::findOrfail($id);
        $governorate->update($request->all());
        flash()->success('Updated');
        return redirect(route('governorate.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $governorate = Governorate::findOrfail($id);
        $governorate->delete();
        flash()->success('Deleted');
        return redirect(route('governorate.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\City;
use App\Governorate;
use Illuminate\Http\Request;

class CityController extends Controller
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
        $cities = City::with('governorate')->paginate(10);
        return view('admin.cities.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.cities.create')->with('governorates',Governorate::all());
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
        $governorate = City::create($request->all());
        flash()->success('success');
        return redirect(route('cities.index'));
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
        $city = City::findOrfail($id);
        return view('admin.cities.edit',compact('city'))->with('governorates',Governorate::all());
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
        $city = City::findOrfail($id);
        $city->update($request->all());
        flash()->success('Updated');
        return redirect(route('cities.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrfail($id);
        $city->delete();
        flash()->success('Deleted');
        return redirect(route('cities.index'));
    }
}

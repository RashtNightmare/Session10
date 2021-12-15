<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Exception;

class TestController2 extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $test= Test::query()->select([
            'name','role_id'
        ])->get();
        return view("Test.all",compact('test'));

    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            return view("Test.sign_in");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name=$request->name;
        $role_id=$request->role_id;
        try {
            $test=Test::create(["name" => $name,"role_id" => $role_id]);
            return $test;
            // return response()->json([
            //     'data' => $role,
            //     'msg' => 'successfully'], 500);
        } catch (Exception $exception) {
            return response()->json([
                'data' => $exception,
                'msg' => 'failed'], 500);
        }
        return view('Test.all');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $test= Test::query()->where('id',$id)->select([
            'id','name','role_id'
        ])->first();
        if (!$test) {
         return response()->json([
                'msg' => "NOT FOUND",
            ],404);}
        return view("Test.edit", compact('test'));

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
        //$role= SELECT *  FROM roles WHERE 'id' = $id
        // $role =  Role::find($id);
        
        $test= Test::query()->where('id', $id)->first();
        if (!$test) {
            return response()->json([
                'msg' => "NOT FOUND",
            ], 404);
        }
        //  $tmp=['name'=>$request->name];
        //  $role->update($tmp);
        //  $role->save();
        //  return view("Role.all",compact('role'));

            $test->name=$request->name;
            $test->role_id=$request->role_id;
            $test->save();
            return $this->index();
          

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        Test::query()->where('id', $id)->delete();
        return $this->index();

    }
}

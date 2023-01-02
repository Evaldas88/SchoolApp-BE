<?php

namespace App\Http\Controllers;

use App\Models\Schools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolsController extends Controller
{
    public function index()
    {
        $schools = Schools::all();


        if ($schools)
            return response()->json([
                'success' => true,
                'message' => $schools
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Cant find school list'
            ], 500);
    }
    public function show($id, Request $request)
    {

        $school = Schools::where('id', $id);

        if ($school->get())
            return response()->json([
                'success' => true,
                'message' => $school->get()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Cant find school'
            ], 500);
    }

    public function store(Request $request)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'city' => 'required',
            'address' => 'required'
        ]);
        $school = new Schools();
        $school->name = $request->name;
        $school->code = $request->code;
        $school->city = $request->city;
        $school->address = $request->address;
        $school->image = $request->image;
        
        if ($school->save())
            return response()->json([
                'success' => true,
                'message' => $school->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Cant save school '
            ], 500);
    }

    public function update($id, Request $request)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'address' => 'required'
        ]);

        $school = Schools::find($id);
        $data = [];

        $data['name'] = $request->name;
        $data['code'] = $request->code;
        $data['city'] = $request->city;
        $data['address'] = $request->address;
        $data['image'] = $request->image;


        if ($school->update($data))
            return response()->json([
                'success' => true,
                'message' => $school->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Cant update  '
            ], 500);
    }

    public function destroy($id)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $school = Schools::where('id', $id);

        if ($school->delete())
            return response()->json([
                'success' => true,
                'message' => 'School deleted '
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Cant delete school'
            ], 500);
    }


    public function search($name = null)
    {
        $school = Schools::where('name', 'like', "%$name%");
        return $school->get();
        //     if ($school->get())
        //         return response()->json([
        //             'success' => true,
        //             'message' => $school->get()
        //         ]);
        //     else
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'cant find schools'
        //         ], 500);
    }
}

 

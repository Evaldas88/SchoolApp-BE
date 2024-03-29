<?php

namespace App\Http\Controllers;
use App\Models\Schools;
use App\Models\User;

use App\Models\Applications;
use Illuminate\Console\Application;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
    
    
{
    public function index()
    {
        $applis = Applications::where('user_id', auth()->user()->id)->get();

        $generatedApplis = [];

        foreach ($applis as $appli) {
            $school = Schools::find($appli->school_id);
            $user = User::find($appli->user_id);
            $appli['school_name'] = $school->name;
            $appli['code'] = $school->code;
            $appli['city'] = $school->city;
            $appli['user'] = $user->email;
            // $appli['address'] = $school->address;
            $generatedApplis[] = $appli;
            
        }

        if ($generatedApplis) {
            return response()->json([
                'success' => true,
                'message' => $generatedApplis
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'cant find applications list'
            ], 500);
        }
    }

    public function show($id)
    {

        if (auth()->user()->role != 0)
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);

        $information = Applications::where('id', $id)->get();

        $allInfo = [];

        foreach($information as $info ) {
            $schools = Schools::find($info->school_id);
            $appl = Applications::find($info->id);
            $user = User::find($info->user_id);
            $info['school_name'] = $schools->name;
            $info['student_code'] = $appl->student_id;
            $info['city'] = $schools->city;
            $info['user_name'] = $user->name;
            $info['school_address'] = $schools->address;
            $info['school_code'] = $schools->code;
            $info['created_at'] = $appl->created_at;
            $allInfo[] = $info;
        }
        if ($allInfo) {
            return response()->json([
                'success' => true,
                'message' => $allInfo
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get list'
            ], 500);
        }
    }

    

    public function all()
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $applis = Applications::all();

        $generatedApplis = [];

        foreach ($applis as $appli) {
            $school = Schools::find($appli->school_id);
            $appli['school_name'] = $school->name;
            $appli['code'] = $school->code;
            $appli['city'] = $school->city;
            $appli['address'] = $school->address;
            $generatedApplis[] = $appli;
        }

        return response()->json([
            'success' => true,
            'message' => $generatedApplis
        ]);
    }


    public function store(Request $request)
    {
    

        $school = new Applications();
        $school->school_id = $request->school_id;
        $school->name = $request->name;
        $school->surname = $request->surname;
        $school->class = $request->class;
        $school->student_id = $request->student_id;
        $school->student_bd = $request->student_bd;
        $school->approved = 0;
        $school->user_id = auth()->user()->id;

        if ($school->save())
            return response()->json([
                'success' => true,
                'message' => $school->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Cant create application'
            ], 500);
    }

    public function status($id, Request $request)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $school = Applications::find($id);
        if ($school->update(['approved' => $school->approved === 0 ? 1 : 0]))
            return response()->json([
                'success' => true,
                'message' => 'Request status changed successfully.'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to change request status.'
            ], 500);
    }

    public function destroy($id, Applications $applis)
    {
        //Authentification
        if (auth()->user()->role != 0)
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $school = Applications::where('id', $id);

        if ($school->delete())
            return response()->json([
                'success' => true,
                'message' => 'Request deleted successfully'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete request'
            ], 500);
    }
    public function destroyAppl($id, Applications $applis)
    {
      

        $school = Applications::where('id', $id);

        if ($school->delete())
            return response()->json([
                'success' => true,
                'message' => 'Request deleted successfully'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete request'
            ], 500);
    }

}
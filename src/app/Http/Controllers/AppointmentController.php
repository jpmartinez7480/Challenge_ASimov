<?php

namespace App\Http\Controllers;

use App\Appointment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller{

    public function index(){
        return response()->json(Appointment::all());

    }

    public function show($id){
        $appointment = Appointment::where('rut',$id)->get();
        return response()->json($appointment);
        #return response()->json(Appointment::find($id));
    }

    public function create(Request $request){
        $rut = $request->rut;
        $day = $request->day;
        $appointment = Appointment::where('rut',$rut)->where('day',$day)->get();
        if(count($appointment)>0)
            return response()->json('you already have an appointment for today',200);
        else{
            $person = Appointment::create($request->all());
            return response()->json($person,201);
        }
            
    }

    public function update($id, Request $request){
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return response()->json($appointment,200);
    }

    public function delete($id){
        Appointment::findOrFail($id)->delete();
        return response('Appointment was cancelled :c');
    }

}
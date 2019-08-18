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

    public function searchById($id){
        $appointment = Appointment::find($id);
        return response()->json($appointment);
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

    public function searchTurnsAvailables($day){
        $turns = Appointment::whereBetween('day',[$day,$day])->orderBy('turn','Asc')->get('turn');
        $turn_desoccupied = [
            ['value'=>'09:00 - 10:00','turn'=>1],
            ['value'=>'10:00 - 11:00','turn'=>2],
            ['value'=>'11:00 - 12:00','turn'=>3],
            ['value'=>'12:00 - 13:00','turn'=>4],
            ['value'=>'13:00 - 14:00','turn'=>5],
            ['value'=>'14:00 - 15:00','turn'=>6],
            ['value'=>'15:00 - 16:00','turn'=>7],
            ['value'=>'16:00 - 17:00','turn'=>8],
            ['value'=>'17:00 - 18:00','turn'=>9],
        ];
        $aux = 1;
        foreach($turns as $t){
            array_splice($turn_desoccupied,$t->turn-$aux,1);
            $aux+=1;
        }
        return response()->json($turn_desoccupied);
        
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
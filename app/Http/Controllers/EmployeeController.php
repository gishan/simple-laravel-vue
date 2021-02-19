<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return $employees;
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
        $newEmployee = new Employee();
        $newEmployee->firstname = $request->employee["firstName"];
        $newEmployee->middlename = $request->employee["middleName"];
        $newEmployee->lastname = $request->employee["lastName"];
        $newEmployee->address = $request->employee["address"];
        $newEmployee->zip = $request->employee["zip"];
        $newEmployee->department_id = $request->employee["departmentId"];
        $newEmployee->country_id = $request->employee["countryId"];
        $newEmployee->state_id = $request->employee["stateId"];
        $newEmployee->city_id = $request->employee["cityId"];
        $newEmployee->birthdate = $request->employee["birthDate"];
        $newEmployee->date_hired = $request->employee["birthDate"];
        $newEmployee->save();

        return $newEmployee;
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
        //
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
        $existingEmployee = Employee::find($id);

        if ($existingEmployee) {
            $existingEmployee->firstname = $request->employee["firstName"];
            $existingEmployee->middlename = $request->employee["middleName"];
            $existingEmployee->lastname = $request->employee["lastName"];
            $existingEmployee->address = $request->employee["address"];
            $existingEmployee->zip = $request->employee["zip"];
            $existingEmployee->department_id = $request->employee["departmentId"];
            $existingEmployee->country_id = $request->employee["countryId"];
            $existingEmployee->state_id = $request->employee["stateId"];
            $existingEmployee->city_id = $request->employee["cityId"];
            $existingEmployee->birthdate = $request->employee["birthDate"];
            $existingEmployee->date_hired = $request->employee["birthDate"];
            $existingEmployee->save();
            return $existingEmployee;
        }

        return "Employee not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingEmployee = Employee::find($id);
        if ($existingEmployee) { 
            $existingEmployee->delete();
            return "Delete success";
        }
        
        return "Employee not found";
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$departments = Department::all();
        $departments = Department::paginate(5);
        return view('departments.allDepartments', [ 'departments'=> $departments ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('departments.index', [ 'departments'=> $departments ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments|max:255'
        ]);
        $department = new Department;
        $department->name = $request->name;
        $department->save();

        return redirect()->route('departments.index')->with('success', 'Nuevo departamento agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::find($id);
        return view('departments.show', ['department' => $department]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $department = Department::find($id);
        $department->name = $request->name;
        $department->save();

        return redirect()->route('departments.index')->with('success', 'Departamento actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $department)
    {
        $department = Department::find($department);
        // Primero elimino todos los empleados asociados al departamento
        $department->employees()->delete();
        // Luego eliminao el departamento
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Departamento eliminado');
    }
}

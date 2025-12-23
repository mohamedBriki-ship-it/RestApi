<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeController extends Controller
{
    /**
     * Display a listing of employees
     */
    public function index()
    {
        $employes = Employe::with('departement')->get();

        return response()->json([
            'success' => true,
            'data' => $employes,
        ]);
    }

    /**
     * Store a newly created employee
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employes,email',
            'telephone' => 'nullable|string|max:20',
            'poste' => 'required|string|max:255',
            'salaire' => 'nullable|numeric|min:0',
            'date_embauche' => 'required|date',
            'departement_id' => 'required|exists:departements,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $employe = Employe::create($request->all());
        $employe->load('departement');

        return response()->json([
            'success' => true,
            'message' => 'Employé créé avec succès',
            'data' => $employe,
        ], 201);
    }

    /**
     * Display the specified employee
     */
    public function show($id)
    {
        $employe = Employe::with('departement')->find($id);

        if (!$employe) {
            return response()->json([
                'success' => false,
                'message' => 'Employé non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $employe,
        ]);
    }

    /**
     * Update the specified employee
     */
    public function update(Request $request, $id)
    {
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json([
                'success' => false,
                'message' => 'Employé non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:employes,email,' . $id,
            'telephone' => 'nullable|string|max:20',
            'poste' => 'sometimes|required|string|max:255',
            'salaire' => 'nullable|numeric|min:0',
            'date_embauche' => 'sometimes|required|date',
            'departement_id' => 'sometimes|required|exists:departements,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $employe->update($request->all());
        $employe->load('departement');

        return response()->json([
            'success' => true,
            'message' => 'Employé mis à jour avec succès',
            'data' => $employe,
        ]);
    }

    /**
     * Remove the specified employee
     */
    public function destroy($id)
    {
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json([
                'success' => false,
                'message' => 'Employé non trouvé'
            ], 404);
        }

        $employe->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employé supprimé avec succès',
        ]);
    }
}

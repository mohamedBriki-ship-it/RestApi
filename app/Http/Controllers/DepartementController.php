<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    /**
     * Display a listing of departments
     */
    public function index()
    {
        $departements = Departement::withCount('employes')->get();

        return response()->json([
            'success' => true,
            'data' => $departements,
        ]);
    }

    /**
     * Store a newly created department
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $departement = Departement::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Département créé avec succès',
            'data' => $departement,
        ], 201);
    }

    /**
     * Display the specified department
     */
    public function show($id)
    {
        $departement = Departement::with('employes')->find($id);

        if (!$departement) {
            return response()->json([
                'success' => false,
                'message' => 'Département non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $departement,
        ]);
    }

    /**
     * Update the specified department
     */
    public function update(Request $request, $id)
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return response()->json([
                'success' => false,
                'message' => 'Département non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $departement->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Département mis à jour avec succès',
            'data' => $departement,
        ]);
    }

    /**
     * Remove the specified department
     */
    public function destroy($id)
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return response()->json([
                'success' => false,
                'message' => 'Département non trouvé'
            ], 404);
        }

        $departement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Département supprimé avec succès',
        ]);
    }
}

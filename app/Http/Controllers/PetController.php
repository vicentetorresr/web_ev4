<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::all();
        return response()->json(['data' => $pets, 'code' => Response::HTTP_OK, 'message' => 'Pets retrieved successfully']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'especie' => 'required|string|max:20',
            'raza' => 'nullable|string|max:20',
            'sexo' => 'required|in:M,F',
            'fechaNacimiento' => 'required|date',
            'numeroAtenciones' => 'required|integer',
            'enTratamiento' => 'boolean',
        ]);

        $pet = Pet::create($validated);
        return response()->json(['data' => $pet, 'code' => Response::HTTP_CREATED, 'message' => 'Pet created successfully']);
    }

    public function show($id)
    {
        $pet = Pet::find($id);
        if (!$pet) {
            return response()->json(['data' => null, 'code' => Response::HTTP_NOT_FOUND, 'message' => 'Pet not found']);
        }
        return response()->json(['data' => $pet, 'code' => Response::HTTP_OK, 'message' => 'Pet retrieved successfully']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'especie' => 'required|string|max:20',
            'raza' => 'nullable|string|max:20',
            'sexo' => 'required|in:M,F',
            'fechaNacimiento' => 'required|date',
            'numeroAtenciones' => 'required|integer',
            'enTratamiento' => 'boolean',
        ]);

        $pet = Pet::find($id);
        if (!$pet) {
            return response()->json(['data' => null, 'code' => Response::HTTP_NOT_FOUND, 'message' => 'Pet not found']);
        }

        $pet->update($validated);
        return response()->json(['data' => $pet, 'code' => Response::HTTP_OK, 'message' => 'Pet updated successfully']);
    }

    public function destroy($id)
    {
        $pet = Pet::find($id);
        if (!$pet) {
            return response()->json(['data' => null, 'code' => Response::HTTP_NOT_FOUND, 'message' => 'Pet not found']);
        }

        $pet->delete();
        return response()->json(['data' => null, 'code' => Response::HTTP_OK, 'message' => 'Pet deleted successfully']);
    }

    public function filtrarPorEspecie($especie)
    {
        $pets = Pet::where('especie', $especie)->get();
        return response()->json(['data' => $pets, 'code' => Response::HTTP_OK, 'message' => 'Pets filtered by species retrieved successfully']);
    }
}

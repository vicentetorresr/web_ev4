<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class PetController extends Controller
{
    public function index()
    {
        try {
            $pets = Pet::all();
            return response()->json(['data' => $pets, 'code' => Response::HTTP_OK, 'message' => 'Mascotas recuperadas exitosamente']);
        } catch (Exception $e) {
            return response()->json(['data' => null, 'code' => Response::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Error al recuperar las mascotas']);
        }
    }

    public function store(Request $request)
    {
        try {
            
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
            return response()->json(['data' => $pet, 'code' => Response::HTTP_CREATED, 'message' => 'Mascota creada exitosamente']);
        } catch (Exception $e) {
            return response()->json(['data' => null, 'code' => Response::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Error al crear la mascota']);
        }
    }

    public function show($id)
    {
        try {
            $pet = Pet::find($id);
            if (!$pet) {
                return response()->json(['data' => null, 'code' => Response::HTTP_NOT_FOUND, 'message' => 'Mascota no encontrada']);
            }
            return response()->json(['data' => $pet, 'code' => Response::HTTP_OK, 'message' => 'Mascota recuperada exitosamente']);
        } catch (Exception $e) {
            return response()->json(['data' => null, 'code' => Response::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Error al recuperar la mascota']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
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
                return response()->json(['data' => null, 'code' => Response::HTTP_NOT_FOUND, 'message' => 'Mascota no encontrada']);
            }

            $pet->update($validated);
            return response()->json(['data' => $pet, 'code' => Response::HTTP_OK, 'message' => 'Mascota actualizada exitosamente']);
        } catch (Exception $e) {
            return response()->json(['data' => null, 'code' => Response::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Error al actualizar la mascota']);
        }
    }

    public function destroy($id)
    {
        try {
            $pet = Pet::find($id);
            if (!$pet) {
                return response()->json(['data' => null, 'code' => Response::HTTP_NOT_FOUND, 'message' => 'Mascota no encontrada']);
            }

            $pet->delete();
            return response()->json(['data' => null, 'code' => Response::HTTP_OK, 'message' => 'Mascota eliminada exitosamente']);
        } catch (Exception $e) {
            return response()->json(['data' => null, 'code' => Response::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Error al eliminar la mascota']);
        }
    }

    public function filtrarPorEspecie($especie)
    {
        try {
            $pets = Pet::where('especie', $especie)->get();
            return response()->json(['data' => $pets, 'code' => Response::HTTP_OK, 'message' => 'Mascotas filtradas por especie recuperadas exitosamente']);
        } catch (Exception $e) {
            return response()->json(['data' => null, 'code' => Response::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Error al filtrar las mascotas por especie']);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeProjectController extends Controller
{
    public function index(string $id)
    {
        $type = Type::find($id);
        if (!$type) return response(null, 404);

        $projects = $type->projects;

        return response()->json(compact('type', 'projects'));
    }
}

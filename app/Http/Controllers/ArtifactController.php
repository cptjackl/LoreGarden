<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artifact;

class ArtifactController extends Controller
{
    public function index()
    {
        $artifacts = Artifact::all();

        return $artifacts;
    }

    public function display($id)
    {
        $artifact = Artifact::findOrFail($id);

        return $artifact;
    }
}

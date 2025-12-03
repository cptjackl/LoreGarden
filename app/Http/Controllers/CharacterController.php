<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();

        return $characters;
    }

    public function display($id)
    {
        $character = Character::findOrFail($id);

        return $character;
    }
}

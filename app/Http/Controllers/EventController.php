<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return $events;
    }

    public function display($id)
    {
        $event = Event::findOrFail($id);

        return $event;
    }
}

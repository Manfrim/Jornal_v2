<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Writer;

class AdminWriterController extends Controller
{
    public function dashboard()
    {
        // Pega todos os escritores
        $writers = Writer::all();

        // Passa os escritores para a view
        return view('admin.dashboard', compact('writers'));
    }
}

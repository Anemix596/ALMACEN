<?php

namespace App\Http\Controllers;

use App\Models\Solicitante;
use App\Models\VerificarLogin;
use Illuminate\Http\Request;

class VerificarLoginController extends Controller
{

    public function vista_solicitante()
    {
        return view('solicitante.index_suministros');
    }

    public function vista_presupuesto()
    {
        return view('presupuesto.index');
    }

    public function vista_almacen()
    {
        return view('almacen.index');
    }

    public function vista_daf()
    {
        return view('daf.index');
    }

    public function vista_bien()
    {
        return view('bien.index');
    }

    public function vista_cotizador()
    {
        return view('cotizador.index');
    }

    public function vista_adquisicion()
    {
        return view('adquisicion.index');
    }
    
}

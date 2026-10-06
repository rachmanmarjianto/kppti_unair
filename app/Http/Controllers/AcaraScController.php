<?php

namespace App\Http\Controllers;

class AcaraScController extends Controller
{
    /**
     * Read-only "Acara" menu for SC — same data as AcaraController::index()
     * (admin), minus the add/edit/delete affordances (SC can only view).
     */
    public function index()
    {
        $menu = 'acara';
        $submenu = '';

        ['acaraList' => $acaraList, 'legendaHari' => $legendaHari] = $this->acaraListDenganPembicara();

        return view('sc.acara', compact('menu', 'submenu', 'acaraList', 'legendaHari'));
    }
}

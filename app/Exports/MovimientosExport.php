<?php

namespace App\Exports;

use App\Models\WalletMovement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MovimientosExport implements FromView 
{
    
    protected $movimientos;

    public function __construct($movimientos)
    {
        $this->movimientos = $movimientos;
    }

    public function view(): View
    {
        return view('reportes.carteras.export', [
            'movimientos' => $this->movimientos
        ]);
    }
}

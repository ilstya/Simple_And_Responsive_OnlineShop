<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    protected $pesanans;
    protected $payments;

    public function __construct($pesanans, $payments)
    {
        $this->pesanans = $pesanans;
        $this->payments = $payments;
    }

    public function view(): View
    {
        return view('admin.reports.export', [
            'pesanans' => $this->pesanans,
            'payments' => $this->payments,
        ]);
    }
}

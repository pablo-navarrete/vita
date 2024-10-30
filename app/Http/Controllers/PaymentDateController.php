<?php

namespace App\Http\Controllers;

use App\Models\PaymentDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PaymentDateController extends Controller
{
    public function index()
    {
       
        return view('admin.paymentDate.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_date' => 'required|integer|min:1|max:31|unique:payment_dates',
        ]);

        PaymentDate::create($request->only('payment_date', 'status'));

        return response()->json([
            'message' => 'Día creado exitosamente'
        ]);
    }

    public function update(Request $request, PaymentDate $paymentDate)
    {
        $request->validate([
            'payment_date' => 'required|unique:payment_dates,payment_date,' . $paymentDate->id,
        ]);

        $paymentDate->update($request->only('payment_date'));

        return redirect()->back()->with('success', 'Fecha de pago actualizada exitosamente.');
    }

    public function getData()
    {
        $paymentDate = DB::table('payment_dates')
        ->get(); 

        return DataTables::of($paymentDate)
            ->addColumn('action', function ($paymentDate) {
                return '<button class="btn btn-sm btn-danger" onclick="deleteClinica(' . $paymentDate->id . ')">Eliminar</button>';
            })
            ->make(true);
    }
}


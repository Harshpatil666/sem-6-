<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Http\Response;
use App\Services\MessengerService;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $vouchers = Voucher::paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'voucher_id' => ['required','unique:vouchers'],
            'name' => 'required',
            'type' => 'required',
            'deduction_amount' => 'required',
            'start_from' => 'required',
            'end_at' => 'required',
            'released_voucher' => 'required'
        ]);
        Voucher::create([
            'voucher_id' => $request['voucher_id'],
            'name' => $request['name'],
            'type' => $request['type'],
            'deduction_amount' => $request['deduction_amount'],
            'start_from' => $request['start_from'],
            'end_at' => $request['end_at'],
            'released_voucher' => $request['released_voucher'],
            'used_voucher' => 0,
            'is_enable' => 1
        ]);

        return redirect()->route('admin.vouchers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Voucher $voucher
     * @return Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        $voucher->update($request->validate([
            'voucher_id' => 'required',
            'name' => 'required',
            'type' => 'required',
            'deduction_amount' => 'required',
            'start_from' => 'required',
            'end_at' => 'required',
            'released_voucher' => 'required',
            'used_voucher' => 'required',
        ]));

        return redirect()->route('admin.vouchers.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function destroy(Voucher $voucher)
    {
        //$voucher = Voucher::findOrFail($voucher_id);
        $voucher->delete();
        return redirect()->route('admin.vouchers.index');
    }


    public function sendUsers(Voucher $voucher){
        (new MessengerService())->notifyVoucher($voucher);
        return redirect()->back()->with('message','Voucher has been sent!');
    }
}

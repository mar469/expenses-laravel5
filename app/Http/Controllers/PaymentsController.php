<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Payment;
use App\Http\Requests\Store\StorePayment;
use App\Http\Requests\Update\UpdatePayment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Auth::user()
            ->payments()
            ->with('expense')
            ->orderByDesc('updated_at')
            ->get();

        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Expense $expense)
    {
        // TODO: Condition: sum($expense->payments.amount) < $expense->amount
        return view('payments.create', compact('expense'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Expense $expense
     * @param StorePayment|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Expense $expense, StorePayment $request)
    {
        $this->authorize('create', Payment::class);

        $payment = Auth::user()->payments()->make(
            $request->only(['amount'])
        );

        $payment->expense_id = $expense->id;
        $payment->save();

        return redirect(route('expenses.show', $expense->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $payment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);

        return view('payments.view', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Payment $payment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Payment $payment)
    {
        $this->authorize('update', $payment);

        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePayment|Request $request
     * @param Payment $payment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdatePayment $request, Payment $payment)
    {
        $this->authorize('update', $payment);

        $payment->update($request->only($payment->getFillable()));

        return redirect(route('payments.show', $payment->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Payment $payment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);

        $payment->delete();

        return redirect()->back();
    }

    /**
     * Allows to moderate the payment
     *
     * @param Payment $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function moderate(Payment $payment)
    {
        // TODO: create PaymentModerateAll permission

        if (Auth::user()->isAdmin()) {
            $action = request('moderate');

            if ($action === 'approve') $payment->accept();
            elseif ($action === 'reject') $payment->reject();
        } else {
            abort(403);
        }

        return redirect()->back();
    }

    public function status(User $user = null, $status)
    {
//        if ($user === null) $user = Auth::user();
        if (empty($user['attributes'])) {
            // laravel's model binding hax
            $user = null;
        }

        $payment_status = [
            'pending' => null,
            'rejected' => -1,
            'accepted' => 1
        ];


        // TODO: refactor this weird construction below (simplify)
        if ( ! $user && $status && Auth::user()->isAdmin()) {
            // ADMIN: get all payments with assent=$status
            $payments = Payment
                ::where('assent', '=', $payment_status[$status]);
        } elseif ( ! $user && $status) {
            // USER: get all payments with assent=$status
            $payments = Auth::user()
                ->payments()
                ->where('assent', '=', $payment_status[$status]);
        } elseif ( $user && $status && Auth::user()->isAdmin()) {
            // ADMIN: get all $user's payments with assent=$status
            $payments = $user
                ->payments()
                ->where('assent', '=', $payment_status[$status]);
        } else $payments = [];

        $payments->orderBy('created_at', 'desc');

        return view('payments.index', ['payments' => $payments->get()]);
    }
}

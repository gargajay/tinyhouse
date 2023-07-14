<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppliedJob;
use App\Models\BankAccount;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['page_title'] = 'Received - Payments';
        $data = [];
        $data['page_title'] = 'Booking - Payments';
        $userObj = User::latest();
        $paymentObj = Payment::where('payment_status', 'succeeded')->with('users')->orderBy('id', 'desc')->latest('created_at');
        if ($request->has('q') && !empty($request->get('q'))) {
            $q = $request->get('q');
            $data['q'] = $q;
            $userIds = $userObj->whereRaw("(name ILIKE '%" . $q . "%' OR first_name ILIKE '%" . $q . "%' OR last_name ILIKE '%" . $q . "%' OR email ILIKE '%" . $q . "%' OR username ILIKE '%" . $q . "%')")->pluck('id')->toArray();
            $result = $paymentObj->whereIn('user_id', $userIds)->paginate(10)->appends(['q' => $q]);
        }
        $result = $paymentObj->paginate(10);
        $data['total_paid'] = Payment::get()->sum('amount') ?? 0;
        $data['page'] = $request->get('page') ?? 1;
        $data['total_received'] = Payment::where('payment_status', 'succeeded')->get()->sum('amount') ?? 0;
        return view('admin.payment.index')->with(compact('data', 'result'));
    }

    public function getPayments(Request $request)
    {
        return Payment::get();
    }
}

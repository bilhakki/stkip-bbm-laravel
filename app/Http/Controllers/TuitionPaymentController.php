<?php

namespace App\Http\Controllers; 

use App\Models\TuitionPayment;
use App\Http\Requests\StoreTuitionPaymentRequest;
use App\Http\Requests\UpdateTuitionPaymentRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TuitionPaymentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TuitionPayment::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse | Response
    {
        if ($request->ajax()) {
            $tuitionPayments = TuitionPayment::query();
            $perPage = $request->input('per_page', 10);

            $tuitionPayments = $tuitionPayments->paginate($perPage);
        }
        return response()->view('pages.tuition-payment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTuitionPaymentRequest $request)
    {
        $request->validated();

        $tuitionPayment = new TuitionPayment();
        $tuitionPayment->payment_at = Carbon::createFromFormat("Y-m-d\TH:i", $request->payment_at);
        $tuitionPayment->amount = $request->amount;
        $tuitionPayment->receipt_number = $request->receipt_number;
        $tuitionPayment->status = $request->status;
        $tuitionPayment->student_id = $request->student_id;
        $tuitionPayment->season_id = $request->season_id;
        $tuitionPayment->save();

        return response()->json([
            'message' => 'TuitionPayment created successfully',
            'data' => $tuitionPayment,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TuitionPayment $tuitionPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, TuitionPayment $tuitionPayment)
    {
        if ($request->ajax()) {
            return response()->json($tuitionPayment);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTuitionPaymentRequest $request, TuitionPayment $tuitionPayment)
    {
        $request->validated();

        $tuitionPayment->payment_at = $request->payment_at;
        $tuitionPayment->amount = $request->amount;
        $tuitionPayment->receipt_number = $request->receipt_number;
        $tuitionPayment->status = $request->status;
        $tuitionPayment->student_id = $request->student_id;
        $tuitionPayment->season_id = $request->season_id;
        $tuitionPayment->save();

        return response()->json([
            'message' => 'Tuition Payment updated successfully',
            'data' => $tuitionPayment,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TuitionPayment $tuitionPayment)
    {
        $tuitionPayment->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Tuition Payment deleted successfully',
            ], 200);
        }
        return redirect()->back();
    }
}

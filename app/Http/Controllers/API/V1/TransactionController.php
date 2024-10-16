<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\TransferRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService  $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function transfer(TransferRequest $request)
    {
        try {
            $result = $this->transactionService->transfer($request->validated());
            return response()->json($result);
        } catch (InsufficientBalanceException $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AccountTrackingHistory;
use App\Models\Arhead;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;

class AccountTrackingController extends Controller
{
    public function save(Request $request)
    {

        $incomingFields = $request->validate([
            'transaction_type' => 'required',
            'amount' => 'required',
            'wallet_id' => 'required',
            'account_id' => 'required',
        ]);

        $incomingFields['user_id'] = auth()->user()->id;
        $incomingFields['transaction_date'] = date('Y-m-d');
        $incomingFields['transaction_time'] = date('H:i');
        $incomingFields['note'] = "Saving from wallet " . $incomingFields['wallet_id'] . " to account " . $incomingFields['account_id'];
        $incomingFields['row_sign'] = +1;
        $incomingFields['month'] = date('m');
        $incomingFields['year'] = date('Y');

        $acth = AccountTrackingHistory::create($incomingFields);

        if ($acth) {
            $incomingFields['account_tracking_historie_id'] = $acth->id;
            $incomingFields['transaction_type'] = "SAVING";
            $incomingFields['transaction_charge'] = 0;
            $incomingFields['from_wallet'] = $incomingFields['wallet_id'];
            $trackingHistory = TrackingHistory::create($incomingFields);

            if ($trackingHistory) {
                $arhead['tracking_history_id'] = $trackingHistory->id;
                $arhead['user_id'] = auth()->user()->id;
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['from_wallet'];
                $arhead['row_sign'] = -1;

                $savedArhead = Arhead::create($arhead);

                if ($savedArhead) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Saving created successfully'
                    ]);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Arhead not created'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Tracking History not created'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Transaction not created'
        ]);
    }

    public function withdraw(Request $request)
    {

        $incomingFields = $request->validate([
            'transaction_type' => 'required',
            'amount' => 'required',
            'wallet_id' => 'required',
            'account_id' => 'required',
        ]);

        $incomingFields['user_id'] = auth()->user()->id;
        $incomingFields['transaction_date'] = date('Y-m-d');
        $incomingFields['transaction_time'] = date('H:i');
        $incomingFields['note'] = "Withdraw from account " . $incomingFields['account_id'] . " to wallet " . $incomingFields['wallet_id'];
        $incomingFields['row_sign'] = -1;
        $incomingFields['month'] = date('m');
        $incomingFields['year'] = date('Y');

        $acth = AccountTrackingHistory::create($incomingFields);

        if ($acth) {
            $incomingFields['account_tracking_historie_id'] = $acth->id;
            $incomingFields['transaction_type'] = "SAVING";
            $incomingFields['transaction_charge'] = 0;
            $incomingFields['to_wallet'] = $incomingFields['wallet_id'];
            $trackingHistory = TrackingHistory::create($incomingFields);

            if ($trackingHistory) {
                $arhead['tracking_history_id'] = $trackingHistory->id;
                $arhead['user_id'] = auth()->user()->id;
                $arhead['amount'] = $trackingHistory['amount'];
                $arhead['transaction_charge'] = $trackingHistory['transaction_charge'];
                $arhead['wallet_id'] = $trackingHistory['to_wallet'];
                $arhead['row_sign'] = +1;

                $savedArhead = Arhead::create($arhead);

                if ($savedArhead) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Withdraw created successfully'
                    ]);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Arhead not created'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Tracking History not created'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Transaction not created'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'List of accounts',
            'data' => AccountResource::collection(Account::where('status', 'active')->get())
        ]);
    }

    public function store(StoreAccountRequest $request)
    {
        $account = Account::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'message' => 'Account created successfully',
            'data' => new AccountResource($account)
        ]);
    }

    public function show(Account $account)
    {
        return response()->json([
            'message' => 'Account detail',
            'data' => new AccountResource($account)
        ]);
    }

    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->update($request->all());
        return response()->json([
            'message' => 'Account updated successfully',
            'data' => new AccountResource($account)
        ]);
    }

    public function destroy(Account $account)
    {
        $account->update(['status' => 'inactive']);
        return response()->json(['message' => 'Account deleted successfully']);
    }
}

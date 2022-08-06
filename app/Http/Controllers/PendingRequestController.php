<?php

namespace App\Http\Controllers;

use App\Models\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;

class PendingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pendingRequest = PendingRequest::with('user')->where('status', 'pending')->get();

        return $this->formatSuccessResponse('Pending requests', $pendingRequest);
    }

     /**
     * Action a pending request.
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function actionAnAdminRequest(Request $request, $uuid)
    {
        $action = $request->action;
        dd($action);

        $pendingRequest = PendingRequest::where('uuid', $uuid)->first();

        if ($action == 'approve') {
            $pendingRequest->status = 'approved';
            $pendingRequest->save();
            // act on the request based on the request type
            return $this->formatSuccessResponse('Request approved', $pendingRequest);
        } elseif ($action == 'reject') {
            $pendingRequest->status = 'rejected';
            $pendingRequest->save();
            return $this->formatSuccessResponse('Request rejected', $pendingRequest);
        } else {
            return $this->formatInputErrorResponse('Invalid action');
        }

    }

    public function executeRequestType($requestType, PendingRequest $pendingRequest){

        
        switch ($requestType){
            case 'create':
                $user = User::create([
                    'first_name' => $pendingRequest->first_name,
                    'last_name' => $pendingRequest->last_name,
                    'email' => $pendingRequest->email,
                    'password' => $pendingRequest->password,
                    'uuid' => Str::uuid()
                ]);
                // create new user
                break;
            case 'update':
                // update user
                $user = User::where('uuid', $pendingRequest->user_uuid)->first();

                $user->first_name = $pendingRequest->first_name;
                $user->last_name = $pendingRequest->last_name;
                $user->email = $pendingRequest->email;
                $user->save();
                break;
            case 'delete':
                // delete user
                break;
            default:
                return $this->formatInputErrorResponse('Invalid request type');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created users in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
      
        if ($validator->fails()) {
            return $this->formatInputErrorResponse($validator->errors()->first());
        }

        $validatedData = $request->all();
        $validatedData['password'] = bcrypt($request->password);
        $validatedData['uuid'] = Str::uuid();
        $validatedData['request_type'] = 'create';
        $validatedData['admin_uuid'] = request()->user()->uuid;

        $pendingRequest = PendingRequest::create($validatedData);

        return $this->formatCreatedResponse('User creation request awaiting approval', $pendingRequest);
    }

    /**
     * Display the specified resource.
     *
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        //
        $pendingRequest = PendingRequest::where('uuid', $uuid)->first();
        if (!$pendingRequest) {
            return $this->notFoundResponse('User not found');
        }
        return $this->formatSuccessResponse('User found', $pendingRequest);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendingRequest  $pendingRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(PendingRequest $pendingRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $uuid)
    {
        //
        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            return $this->notFoundResponse('User you are trying to update does not exist');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        if ($validator->fails()) {
            return $this->formatInputErrorResponse($validator->errors()->first());
        }

        $validatedData = $request->all();
        $validatedData['request_type'] = 'update';
        $validatedData['uuid'] = Str::uuid();
        $validatedData['admin_uuid'] = request()->user()->uuid;
        $validatedData['user_uuid'] = $user->uuid;

        $pendingRequest = PendingRequest::create($validatedData);
        return $this->formatCreatedResponse('User update awaiting approval', $pendingRequest);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    {
        //
        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            return $this->notFoundResponse('User you are trying to delete does not exist');
        }
        
        $pending = PendingRequest::create([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'uuid' => Str::uuid(),
            'request_type' => 'delete',
            'admin_uuid' => request()->user()->uuid,
            'user_uuid' => $user->uuid,
        ]);

        // Todo:: when a delete is approved the user uuid should be marked as a soft delete

        return $this->formatSuccessResponse('User deletion request awaiting approval', $pending);
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * @group User management
 *
 * APIs for managing users
 */

class UserController extends Controller
{
    /**
     * Construct.
     *
     * @group Account management
     */
    public function __construct()
    {
        //
    }

/**
     * Update a user's password.
     *
     * @urlParam user_id integer required The ID of the User example 23
     * @group Account management
     *
     * @response 200 {"id": 4, "name": "Jessica Jones"}
     * @responseField id The id of the user
     * @responseField name The name of the user
     */
    public function update($user_id) {
        return response()->json(['dos'=>'uno']);
        return json_encode(['dos'=>'uno']);
    }

    /**
     * Get Users data
     *
     * @urlParam user_id integer required the ID of the user example 12
     *
     * @group User management
     *
     * @response scenario=success {
     *  "id": 4,
     *  "name": "Jessica Jones"
     * }
     * @response status=404 scenario="user not found" {"message": "User not found"}
     */
    public function getUserData($user_id) {
        return response()->json(['uno'=>'dos']);
    }

    /**
     * Return all Users
     */
    public function getUserList() {
        return json_encode(['uno'=>'dos']);

    }

    //
}

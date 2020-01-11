<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

use App\User;
use App\UserGroup;
use App\Division;
use App\General;

use Validator;
use Illuminate\Validation\Rule;

use App\DataTables\UsersDataTable;

class UserController extends Controller
{

    /**
     * The game dataTable instance.
     */
    protected $dataTable;

    /**
     * Create a new controller instance.
     *
     * @param  UsersDataTable  $dataTable
     * @return void
     */
    public function __construct(UsersDataTable $dataTable)
    {
        $this->middleware('pageaccess:user,view');
        $this->middleware('pageaccess:user,create')->only('store');
        $this->middleware('pageaccess:user,alter')->only(['edit', 'update']);
        $this->middleware('pageaccess:user,drop')->only('destroy');

        $this->general = new General;

        $this->dataTable = $dataTable;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $user_groups = UserGroup::all();
        $divisions = Division::all();

        return $this->dataTable->render('pages.user.user', compact('user_groups', 'divisions'));

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'passcode' => 'required|min:6',
            'division' => 'required',
            'group_id' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->has('division')) {
                $errors->add('division[]', 'The division field is required.');
            }

            return response()->json([
                'errors' => $errors
            ]);

        }

        User::create([
            'division' => json_encode(['id' => implode(',', $request->division)]),
            'group_id' => $request->group_id,
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => md5(base64_encode($request->password)),
            'passcode' => md5(base64_encode($request->passcode)),
        ]);

        return response()->json(['heading' => 'Success!', 'text' => 'New user has been created.', 'icon' => 'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $user = User::find($id);

        $data = [
            'name' => ['input_value' => $user->name],
            'email' => ['input_value' => $user->email],
            'username' => ['input_value' => $user->username],
            'password' => ['input_value' => $user->password],
            'password_confirmation' => ['input_value' => $user->password],
            'passcode' => ['input_value' => $user->passcode],
            'division[]' => ['input_type' => 'selectpicker', 'input_value' => explode(',', json_decode($user->division)->id)],
            'group_id' => ['input_type' => 'selectpicker', 'input_value' => $user->group_id]
        ];

        return response()->json($data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                        ->ignore($id)
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')
                        ->ignore($id)
            ],
            'password' => 'required|string|min:6|confirmed',
            'passcode' => 'required|min:6',
            'division' => 'required',
            'group_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::find($id);

        $user->division = json_encode(['id' => implode(',', $request->division)]);
        $user->group_id = $request->group_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;

        if ($request->password != $user->password) {
            $user->password = md5(base64_encode($request->password));
        }

        if ($request->passcode != $user->passcode) {
            $user->passcode = md5(base64_encode($request->passcode));
        }

        $user->save();

        return response()->json(['heading' => 'Success!', 'text' => $request->get('name').' has been updated.', 'icon' => 'success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $user = User::find($id);

        $user->delete();

        return response()->json(['heading' => 'Deleted!', 'text' => 'User has been deleted.', 'icon' => 'error']);

    }
}

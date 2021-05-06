<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function data_list(Request $request)
    {
        $users = User::select(['id','name','email']);

        return Datatables::of($users)
                ->filter(function ($query) use ($request) {
                    if ($request->has('name')) {
                        $query->whereRaw('LOWER(name) like  ?', ["%{$request->post('name')}%"]);
                    }

                    if ($request->has('email')) {
                        $query->whereRaw('LOWER(email) like  ?', ["%{$request->post('email')}%"]);
                    }
                })
                ->addColumn('action', function ($user) {
                    $btn = '';
                    if ( \Laratrust::hasRole('administrator') )
                    {
                        $btn = '<a href="'. route('user.edit', $user->id) .'" class="btn btn-icon btn-sm btn-flat-success" title="edit">
                                    <i class="far fa-edit"></i>
                                </a> ';
    
                        $btn .=' <a href="javascript:void(0)" data-url="'.route('user.destroy', $user->id).'" data-token="'.csrf_token().'" class="btn btn-icon btn-sm btn-flat-danger table-delete">
                                    <i class="far fa-trash-alt"></i>
                                </a>';
                    }

                    return $btn;
                })
                ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('display_name', 'id')->all();

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'role_id'  => 'required',
                'name'     => 'required',
                'email'    => 'required|unique:users',
                'password' => 'required|same:password-confirm',
                'password-confirm' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $user = new User;

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->attachRole($request->role_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'redirect' => route('user.index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::pluck('display_name', 'id')->all();

        $user = User::select(['id','name','email'])
                        ->addSelect(
                            [
                                'role_id' => RoleUser::select('role_id')->whereColumn('user_id', 'users.id')->limit(1)
                            ]
                        )
                        ->firstWhere('id', $id);

        return view('user.edit', compact('roles', 'user'));
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
        $validator = Validator::make($request->all(), 
            [
                'role_id'  => 'required',
                'name'     => 'required',
                'email'    => 'required|unique:users,email,'.$id,
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $user = User::select(['id','name','email'])
                        ->addSelect(
                            [
                                'role_id' => RoleUser::select('role_id')->whereColumn('user_id', 'users.id')->limit(1)
                            ]
                        )
                        ->findorFail($id);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        $user->detachRole($user->role_id);
        $user->attachRole($request->role_id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'redirect' => route('user.index')
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['success' => true]);
    }
}
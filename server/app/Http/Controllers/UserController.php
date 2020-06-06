<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Faz login
     *
     * @param Request $request
     * @return array|bool[]
     */
    public function login(Request $request) {

        $validate = $this->userService->validateLogin($request);

        if($validate->fails()){
            return [
                "status" => false,
                "errors" => $validate->errors()
            ];
        }

        $data = $request->all();

        if(\Auth::attempt(['username'=>$data['username'],'password'=>$data['password']])){
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->plainTextToken;
            return [
                "status" => true,
                "user" => new UserResource($user)
            ];
        }else{
            return ['status' => false, 'errors' => 'Confira username e senha e tente novamente'];
        }
    }
    /**
     * Retorna a listagem de todos os usuarios do sistema
     *
     * @return array|string
     */
    public function index()
    {
        try {
            return ['status' => true , 'data' =>  UserResource::collection(User::all())];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * cria um usuario.
     *
     * @param  Request  $request
     */
    public function store(Request $request)
    {
        try {
            $validate = $this->userService->validateStore($request);
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $user = $this->userService->createUser($request);

            return [
                "status" => true,
                "user" => new UserResource($user)
            ];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Mostra os dados do usuario.
     *
     * @param  User  $user
     */
    public function show(User $user)
    {
        try {
            return [
                "status" => true,
                "user" => new UserResource($user)
            ];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Atualiza um usuario.
     *
     * @param  Request  $request
     * @param  User  $user
     */
    public function update(Request $request, User $user)
    {
        try {
            if (isset($request->password)){
                $validate = $this->userService->validateWitPassword($request,$user);
                if ($validate->fails()){
                    return [
                        "status" => false,
                        "errors" => $validate->errors()
                    ];
                }
                $user->password = Hash::make($request->password);
            }else{
                $validate = $this->userService->validateNoPasswordUpdate($request, $user);
                if ($validate->fails()){
                    return [
                        "status" => false,
                        "errors" => $validate->errors()
                    ];
                }
                $user->username = $request->username;
                $user->name = $request->name;
                $user->email = $request->email;
            }

            $user->fill($request->all());
            if(!$user->save()){
                return [
                    "status" => false,
                    "errors" => 'O usuario não pode ser atualizado'
                ];
            }
            return [
                "status" => true,
                "user" => new UserResource($user)
            ];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Apaga um usuario.
     *
     * @param  User  $user
     */
    public function destroy(User $user)
    {
        try {
            if(!$user->delete()){
                return [
                    "status" => false,
                    "errors" => 'Usuario não pode ser apagado'
                ];
            }
            return [
                "status" => true,
                "message" => 'Usuario apagado'
            ];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }
}

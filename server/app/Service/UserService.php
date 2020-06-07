<?php


namespace App\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class UserService
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateLogin(Request $request){
        return Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateStore(Request $request){
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createUser(Request $request){
        $image = 'default.png';
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image
        ]);
        $user->token =  $user->createToken($user->username)->plainTextToken;
        return $user;
    }

    public function updateUser($data, $user){
        $user->username = $data['username'];
        $user->name = $data['name'];
        $user->email = $data['email'];


        return $user;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateWitPassword($data,User $user){
        return  Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateNoPasswordUpdate($data,User $user){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);
    }

    public function validateImage($data, $user){
        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['png', 'jpg', 'svg','jpeg'];
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );
            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }
            // check base64 format
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }
            return true;
        });

        return Validator::make($data,
            ['image' => 'base64image'],
            ['base64image'=> 'Imagem inválida']
        );
    }

    public function saveUserImage($data, $user){
        $time = time();
        $diretorioPai = 'perfils';
        $diretorioImagem = $diretorioPai.DIRECTORY_SEPARATOR.'perfil_id'.$user->id;
        $ext = substr($data['image'], 11, strpos($data['image'], ';') -11 );

        $urlImagem = $diretorioImagem.DIRECTORY_SEPARATOR.$time.'.'.$ext;

        $file = str_replace('data:image/'.$ext.';base64', '', $data['image']);
        $file = base64_decode($file);

        if (!file_exists($diretorioPai)){
            mkdir($diretorioPai, 0700);
        }

        if ($user->image){
            $imgUser = str_replace(asset('/'), '', $user->image);

            if (file_exists($imgUser)){
                unlink($imgUser);
            }
        }

        if (!file_exists($diretorioImagem)){
            mkdir($diretorioImagem, 0700);
        }

        file_put_contents($urlImagem, $file);

        return $urlImagem;
    }
}

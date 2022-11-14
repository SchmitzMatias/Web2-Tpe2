<?php
require_once './app/views/api.view.php';
require_once './app/helpers/auth-api.helper.php';
require_once './app/models/user.model.php';

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}


class AuthApiController{
    private $view;
    private $authHelper;
    private $userModel;

    public function __construct() {
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->userModel = new UserModel();
    }

    public function getToken() {
        $basic = $this->authHelper->getAuthHeader();
        
        if(empty($basic)){
            $this->view->response('No autorizado', 401);
            return;
        }
        $basic = explode(" ",$basic);
        
        if($basic[0]!="Basic"){
            $this->view->response('La autenticación debe ser Basic', 401);
            return;
        }

        $userpass = base64_decode($basic[1]);
        $userpass = explode(":", $userpass);
        $user = $userpass[0];
        $pass = $userpass[1];

        $dbUser = $this->userModel->getUserByEmail($user);

        if ($dbUser && password_verify($pass, $dbUser->password)){
            
            $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );
            $payload = array(
                'id' => 1,
                'name' => $user,
                'exp' => time()+3600
            );
            $header = base64url_encode(json_encode($header));
            $payload = base64url_encode(json_encode($payload));
            $signature = hash_hmac('SHA256', "$header.$payload", Key, true);
            $signature = base64url_encode($signature);
            $token = "$header.$payload.$signature";
            $this->view->response($token);
        }else{
            $this->view->response('No autorizado', 401);
        }
    }


}

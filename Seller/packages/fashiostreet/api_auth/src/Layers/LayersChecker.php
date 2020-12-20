<?php
namespace fashiostreet\api_auth\Layers;
use Activation;
use fashiostreet\api_auth\Exceptions\ActivationException;

class LayersChecker {

    public function Logincheck($user){
        if(!Activation::completed($user))
        {
            throw new ActivationException('please activate your account before login');
        }
        return true;
    }
}

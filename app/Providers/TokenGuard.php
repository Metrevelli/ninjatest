<?php

namespace App\Providers;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;

class TokenGuard implements Guard
{
    use GuardHelpers;

    public function __construct(UserProvider $provider, protected $request)
    {
        $this->setProvider($provider);
    }

    public function check(): bool
    {
        return $this->validate($this->request->toArray());
    }

    public function user(): Authenticatable | null
    {
        if (! is_null($this->user)) {
            return $this->user;
        }
        return null;
    }

    public function validate(array $credentials = []): bool
    {
        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        $token = $this->getTokenFromRequest() ?? null;

        if($email && $password) {
            $user = $this->getProvider()->retrieveByCredentials($credentials);
            if (! is_null($user) && $this->getProvider()->validateCredentials($user, $credentials)) {
                $this->setUser($user);
//                dd('true');
                return true;
            }
        } else if ($token) {
            $user = $this->getProvider()->retrieveByToken(null, $token);
            if (! is_null($user) && $this->getProvider()->validateTokenCredentials($token)) {
                $this->setUser($user);
                return true;
            }
        }

        return false;
    }

    public function getTokenFromRequest()
    {
        $token = $this->request->header('Authorization');
        $token = \trim((string) \preg_replace('/^\s*Bearer\s/', '', $token));

        if (!$token) {
            $token = $this->request->query('access_token');
        }

        return $token;
    }
}

<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Auth\AuthenticationException;
use App\User;

class Login
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $email    = $args['email'];
        $password = $args['password'];

        // Find user
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password))
        {
            // Login OK
            $token = $user->createToken('api_login')->accessToken;

            event(new LoginEvent('passport', $user, false));

            return [
                'token' => $token
            ];
        }
        else
        {
            // Authentication failed
            return [
                'token' => null
            ];
        }
    }
}

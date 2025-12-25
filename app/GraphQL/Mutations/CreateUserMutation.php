<?php

namespace App\GraphQL\Mutation;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $data = [
            'name' => $args['name'],
            'email' => $args['email'] ?? strtolower(preg_replace('/\s+/', '.', $args['name'])) . '@example.test',
            // пароль не обязателен; если в базе NOT NULL — можно сгенерировать:
            'password' => bcrypt(\Illuminate\Support\Str::random(12)),
        ];

        return User::create($data);
    }
}

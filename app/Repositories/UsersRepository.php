<?php

namespace App\Repositories;


use App\User;

class UsersRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @return User[]
     */
    public function teachers()
    {
        return $this->model->all();
    }
}
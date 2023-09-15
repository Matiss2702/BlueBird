<?php

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\QueryBuilder;

class RoleMiddleware extends Middleware
{
    protected $requiredRole;

    public function __construct($requiredRole)
    {
        $this->requiredRole = $requiredRole;
    }

    public function handle()
    {
        if (!$this->hasRequiredRole()) {
            redirectHome();
        }
    }

    private function hasRequiredRole(): bool
    {
        // TODO : utiliser un vrai token au lieu d'un mail
        $userId = QueryBuilder::table('user')
            ->select(['id'])
            ->where('email', $this->getTokenLogin())
            ->getColumn('id');

        $isUserHasRequiredRole = QueryBuilder::table('user_role')
            ->select(['user_role.id'])
            ->join('user', function($join) {
                $join->on('user_role.id_user', '=', 'user.id');
            })
            ->join('role', function($join) {
                $join->on('user_role.id_role', '=', 'role.id');
            })
            ->where('user.id', $userId)
            ->andWhere('role.name', $this->requiredRole)
            ->exists();

        return $isUserHasRequiredRole;
    }
}

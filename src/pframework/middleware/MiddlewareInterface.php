<?php

namespace pframework\middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $next);
}
<?php

namespace PHPMaker2022\pubinamarga;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * form_pengaduan controller
 */
class FormPengaduanController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FormPengaduan");
    }
}

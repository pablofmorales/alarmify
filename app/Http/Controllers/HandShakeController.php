<?php

namespace App\Http\Controllers;

use App\Actions\ConfirmApplicationHandShakeAction;
use App\Exceptions\NotFoundApplicationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HandShakeController extends Controller
{
    /**
     * @var ConfirmApplicationHandShakeAction
     */
    private ConfirmApplicationHandShakeAction $confirmApplication;

    /**
     * HandShakeController constructor.
     * @param ConfirmApplicationHandShakeAction $confirmApplication
     */
    public function __construct(ConfirmApplicationHandShakeAction $confirmApplication)
    {
        $this->confirmApplication = $confirmApplication;
    }

    /**
     * @param string $appName
     * @return Response
     */
    public function index(string $appName) : Response
    {
        try {
            $this->confirmApplication->execute($appName);
            return new Response(['status' => 'ok'], Response::HTTP_ACCEPTED);
        } catch (NotFoundApplicationException $e) {
            return new Response(
                [
                    'status' => 'failed',
                    'message' => $e->getMessage()
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}

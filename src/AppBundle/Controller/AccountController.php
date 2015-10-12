<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * AccountController.
 *
 * @author Florian Weber <florian.weber.de@icloud.com>
 */
class AccountController extends Controller
{
    public function collectionAction()
    {
        return $this->render('Account/collection.html.twig');
    }

    public function createAction(Request $request)
    {
        //new user account with nylas
        //https://nylas.com/docs/platform#server_side_explicit_flow

        //step 1
        if ($request->get('step') == 'nylas') {
            return $this->redirect('https://api.nylas.com/oauth/authorize'.'?'.http_build_query([
                'client_id' => $this->container->getParameter('nylas.client_id'),
                'response_type' => 'code',
                'scope' => 'email',
                'login_hint' => '',
                'redirect_uri' => $this->generateUrl('accounts_create', [
                    'step' => 'auth',
                ], true),
            ]));
        }

        //step 3
        if ($request->get('step') == 'auth') {
            $code = $request->get('code');

            $_response = $client->request('POST', 'https://api.nylas.com/oauth/token', [
                'client_id' => $this->container->getParameter('nylas.client_id'),
                'client_secret' => $this->container->getParameter('nylas.client_secret'),
                'grant_type' => 'authorization_code',
                'code' => $code,
            ]);
        }

        return $this->render('Account/create.html.twig');
    }
}

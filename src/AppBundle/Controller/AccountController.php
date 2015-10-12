<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Seld\JsonLint\JsonParser;
use GuzzleHttp\Client;
use AppBundle\Entity\Account;

/**
 * AccountController.
 *
 * @author Florian Weber <florian.weber.de@icloud.com>
 */
class AccountController extends Controller
{
    public function collectionAction()
    {
        $accounts = $this->getDoctrine()->getRepository('AppBundle:Account')->findByUser($this->getUser());

        return $this->render('Account/collection.html.twig', [
            'accounts' => $accounts,
        ]);
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
            $client = new Client();
            $parser = new JsonParser();

            $_response = $client->request('POST', 'https://api.nylas.com/oauth/token'.'?'.http_build_query([
                'client_id' => $this->container->getParameter('nylas.client_id'),
                'client_secret' => $this->container->getParameter('nylas.client_secret'),
                'grant_type' => 'authorization_code',
                'code' => $code,
            ]), ['verify' => false]);

            $data = $parser->parse($_response->getBody());

            $account = new Account();
            $account
                ->setAccessToken($data->access_token)
                ->setEmailAddress($data->email_address)
                ->setProvider($data->provider)
                ->setAccountId($data->account_id)
                ->setUser($this->getUser())
                ->setOpenDate(new \DateTime())
            ;

            $em = $this->getDoctrine()->getManager();
            $em->persist($account);
            $em->flush();

            //set flash message
            $this->addFlash(
                'notice',
                'The Account was created!'
            );

            //redirect to update page
            return $this->redirectToRoute('accounts_update', [
                'accountId' => $account->getAccountId(),
            ]);
        }

        return $this->render('Account/create.html.twig');
    }

    public function updateAction(Request $request, $accountId)
    {
        $account = $this->getDoctrine()->getRepository('AppBundle:Account')->findOneByAccountId($accountId);

        if (!$account) {
            throw new \Exception('The requested Account was not found!');
        }

        if ($request->get('sent', 0) == 1) {
            $account
                ->setShortName($request->get('shortname'))
            ;

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            //redirect to account collection
            return $this->redirectToRoute('accounts_collection');
        }

        return $this->render('Account/update.html.twig', [
            'account' => $account,
        ]);
    }

    public function deleteAction(Request $request, $accountId)
    {
        $account = $this->getDoctrine()->getRepository('AppBundle:Account')->findOneByAccountId($accountId);

        if (!$account) {
            throw new \Exception('The requested Account was not found!');
        }

        if ($request->get('sent', 0) == 1) {
            //redirect to account collection
            return $this->redirectToRoute('accounts_collection');
        }

        return $this->render('Account/delete.html.twig', [
            'account' => $account,
        ]);
    }
}

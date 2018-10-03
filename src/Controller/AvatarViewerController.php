<?php

namespace App\Controller;

use App\Controller\DataValidation\EmailValidator;
use App\Controller\Persistence\JSONStore;
use App\Entity\UserList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\ProfileImageRetrieval\GravatarImageObtainer;
use App\Controller\ProfileImageRetrieval\LibravatarImageObtainer;

class AvatarViewerController extends AbstractController {
    private $store;
    private $users;

    public function __construct() {
        $this->store = new JSONStore();
        $users = $this->store->getUsers();

        $this->users = new UserList($users);
    }

    /**
     * @Route("/", name="AvatarViewer")
     * @param mixed $submissionResult
     * @param mixed $submissionMessage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($submissionResult = null, $submissionMessage = null) {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add("email");
        $formBuilder->setAction($this->generateUrl("handleFormSubmission"));
        $form = $formBuilder->getForm();

        return $this->render('AvatarViewer/index.html.twig', [
            'controller_name' => 'AvatarViewerController',
            'users' => $this->users->getUsers(),
            'form' => $form->createView(),
            'submission_result' => $submissionResult,
            'submission_message' => $submissionMessage
        ]);
    }

    /**
     * @Route("handleFormSubmission", name="handleFormSubmission")
     * @Template()
     */
    public function handleRequest(Request $request) {
        $form = $request->request->get("form");
        $email = $form["email"];

        if (EmailValidator::validate($email)) {
            $profile_image_url = (new GravatarImageObtainer())->getImageURLForEmail($email) ?: (new LibravatarImageObtainer())->getImageURLForEmail($email);

            $newUser = new User($email, $profile_image_url);

            $this->users = new UserList(array_merge($this->users->getUsers(), array($newUser)));
            $this->store->saveUsers($this->users->getUsers());

            return $this->index(true);
        } else { // TODO: possible improvement: do not render the view again, but display an error message near the form's submit button
            return $this->index(false, "The provided email is invalid.");
        }
    }
}

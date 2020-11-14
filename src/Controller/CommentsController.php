<?php

namespace App\Controller;

use App\Dto\Comment;
use App\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use JsonRpc\Client;

class CommentsController extends AbstractController
{
    /**
     * @Route("/comments/{pageUid}", name="comments")
     */
    public function index(
        Request $request,
        Client $client,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        string $pageUid = ''
    ): Response {
        $notBlank = new NotBlank();
        $notBlank->message = 'Please provide page UUID';

        $uuid = new Uuid();
        $uuid->message = 'Invalid page UUID was provided';

        $violations = $validator->validate($pageUid, [$notBlank, $uuid]);

        if (count($violations) === 0) {

            $form = $this->createForm(CommentType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var Comment $comment */
                $comment = $form->getData();
                $comment->setPageUid($pageUid);

                $normalizedComment = $serializer->normalize($comment, null, [
                    AbstractNormalizer::IGNORED_ATTRIBUTES => ['createdAt']
                ]);

                if ($client->call('add', $normalizedComment)) {
                    $this->addFlash('success', 'Comment was added');
                } else {
                    $this->addFlash('warning', 'There was error adding a comment');
                }

                return $this->redirectToRoute('comments', [
                    'pageUid' => $pageUid,
                ]);
            }

            if ($client->call('get', ['page_uid' => $pageUid])) {
                $comments = $serializer->denormalize($client->result, Comment::class . '[]');
            } else {
                $comments = [];
            }

            return $this->render('comments.html.twig', [
                'title' => 'Leave a comment',
                'form' => $form->createView(),
                'comments' => $comments,
            ]);
        } else {
            return $this->render('errors.html.twig', [
                'title' => 'Error',
                'violations' => $violations
            ]);
        }
    }
}

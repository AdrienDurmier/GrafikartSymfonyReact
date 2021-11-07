<?php

namespace App\Security;

use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * It grants or denies permissions for actions related to blog posts (such as
 * showing, editing and deleting posts).
 *
 * See https://symfony.com/doc/current/security/voters.html
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class CommentVoter extends Voter
{
    const EDIT = 'edit_comment';

    /**
     * {@inheritdoc}
     */
    protected function supports(string $attribute, $subject): bool
    {
        // this voter is only executed for three specific permissions on Post objects
        return $subject instanceof Comment && \in_array($attribute, [self::EDIT], true);
    }

    /**
     * {@inheritdoc}
     *
     * @param Comment $subject
     */
    protected function voteOnAttribute(string $attribute, $comment, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User || !$comment instanceof Comment) {
            //return false;
        }

        return $user === $comment->getAuthor();
    }
}

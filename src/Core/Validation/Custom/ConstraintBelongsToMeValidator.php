<?php


namespace App\Core\Validation\Custom;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


class ConstraintBelongsToMeValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }
    
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ConstraintBelogsToMe) {
            throw new UnexpectedTypeException($constraint, ConstraintBelogsToMe::class);
        }
        
        if (null === $value || '' === $value) {
            return;
        }

        $value = null;
        if($constraint->userId !== null){
            $value = $constraint->userId;
        }else {
            //get logged in user
            $value = $this->tokenStorage->getToken()->getUser();
        }

        $entity = $this->entityManager->getRepository($constraint->class)->findBy([
            'id' => $value,
            $constraint->field => $value
        ]);
        
        if (count($entity) === 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{class}}', $constraint->class)
                ->setParameter('{{id}}', $value)
                ->addViolation();
        }
    }
}
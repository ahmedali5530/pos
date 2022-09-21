<?php


namespace App\Core\Validation\Custom;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ConstraintValidEntityValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ConstraintValidEntity) {
            throw new UnexpectedTypeException($constraint, ConstraintValidEntity::class);
        }

        if (null === $value || '' === $value || is_array($value)) {
            return;
        }

        $entity = $this->entityManager->getRepository($constraint->class)->findBy([
            $constraint->field => $value
        ]);

        if (count($entity) === 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{class}}', $constraint->class)
                ->setParameter('{{id}}', $value)
                ->setParameter('{{entityName}}', $constraint->entityName)
                ->addViolation();
        }
    }
}

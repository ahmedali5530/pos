<?php


namespace App\Factory\Controller;


use App\Core\Dto\Common\Validation\ValidationErrorResponseDto;
use App\Core\Validation\ValidationResult;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ApiResponseFactory
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function json($data = null, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        $json = $this->serializer->serialize($data, 'json', array_merge([
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ], $context));

        return new JsonResponse($json, $status, $headers, true);
    }

    public function validationError($data, $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        if ($data instanceof ValidationResult) {
            $data = ValidationErrorResponseDto::createFromValidationResult($data);
        } else if ($data instanceof ConstraintViolationListInterface) {
            $data = ValidationErrorResponseDto::createFromConstraintViolationList($data);
        } else if (is_string($data)) {
            $data = ValidationErrorResponseDto::createFromErrorMessage($data);
        }

        return $this->json($data, $statusCode);
    }

    public function unauthorized($data = null): JsonResponse
    {
        return $this->json($data, Response::HTTP_UNAUTHORIZED);
    }

    public function notFound($data = null): JsonResponse
    {
        return $this->json($data, Response::HTTP_NOT_FOUND);
    }

    public function download($file, $contentType = 'application/octet-stream'): BinaryFileResponse
    {
        $response = new BinaryFileResponse($file);
        $response->headers->set('Content-Type',$contentType);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }
}

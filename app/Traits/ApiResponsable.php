<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

trait ApiResponsable
{
    /**
     * HTTP Status code
     * @var int
     */
    protected $statusCode = 200;

    private function setStatusCode($statusCode = 200)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * HTTP Status code Getter
     *
     * @param null
     * @return int $this->statusCode
     */
    private function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Respond OK
     *
     * Standard response for successful HTTP requests. The actual response will depend
     * on the request method used. In a GET request, the response will contain an entity
     * corresponding to the requested resource. In a POST request, the response will
     * contain an entity describing or containing the result of the action
     *
     * @param string $message
     * @param null $data
     * @return mixed
     */
    public function respondOk($message = 'OK', $data = null)
    {
        return $this->setStatusCode(200)->respondWithSuccess($message, $data);
    }

    /**
     * Respond Created
     *
     * The request has been fulfilled, resulting in the creation of a new resource.
     *
     * @param string $message
     * @param null $data
     * @return mixed
     */
    public function respondCreated($message = 'Created', $data = null)
    {
        return $this->setStatusCode(201)->respondWithSuccess($message, $data);
    }

    /**
     * Respond No Content (Success)
     *
     * The server successfully processed the request and is not returning any content.
     *
     * @param string $message
     * @param mixed $data
     * @return mixed
     */
    public function respondNoContent($message = 'No content', $data = null)
    {
        return $this->setStatusCode(204)->respondWithSuccess($message, $data);
    }

    /**
     * Respond Bad Request
     *
     * The server cannot or will not process the request due to an apparent client error
     * (e.g., malformed request syntax, size too large, invalid request message framing,
     * or deceptive request routing).
     *
     * @param string $message
     * @param mixed $data
     * @return mixed
     */
    public function respondBadRequest($message = 'Bad request', $data = null)
    {
        return $this->setStatusCode(400)->respondWithError($message, $data);
    }

    /**
     * Respond Unauthorized
     *
     * Unauthenticated
     *
     * @param string $message
     * @return mixed
     */
    public function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * Respond Not Found
     *
     * The requested resource could not be found but may be available in the future.
     * Subsequent requests by the client are permissible.
     *
     * @param string $message
     * @param mixed $data
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found', $data = null)
    {
        return $this->setStatusCode(200)->respondWithError($message, $data);
    }

    /**
     * Respond Unprocessable Entity
     *
     * The requested resource could not be found but may be available in the future.
     * Subsequent requests by the client are permissible.
     *
     * @param string $message
     * @param null $data
     * @return mixed
     */
    public function respondUnprocessableEntity($message = 'Unprocessable Entity', $data = null)
    {
        return $this->setStatusCode(422)->respondWithError($message, $data);
    }

    /**
     * Respond internal Error
     *
     * A generic error message, given when an unexpected condition
     * was encountered and no more specific message is suitable.
     *
     * @param string $message
     * @param null $exception
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error', $exception = null)
    {
        return $this->setStatusCode(500)->respondWithError($message, $exception);
    }

    /**
     * Respond Not Implemented
     *
     * The server either does not recognize the request method,
     * or it lacks the ability to fulfill the request.
     * Usually this implies future availability (e.g., a new feature of a web-service API)
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotImplemented($message = 'Not Implemented')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * General Respond with success
     *
     * @param string $message
     * @param null $data
     * @return mixed
     */
    public function respondWithSuccess($message, $data = null)
    {
        $response = [
            'success' => [
                'message' => $message,
                'code'    => $this->statusCode
            ],
            'data' => $data
        ];

        return response()->json($response);
    }

    /**
     * General Respond with error
     *
     * @param $message
     * @param null $data
     * @param int $code
     * @return JsonResponse
     */
    public function respondWithError($message, $data = null, $code = 200)
    {
        $response = [
            'error' => [
                'message' => $message,
                'code'    => $code
            ],
            'data' => $data
        ];

        return response()->json($response);
    }


    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException($this->respondUnprocessableEntity('validation_error', ['errors' => $errors]));
    }
}

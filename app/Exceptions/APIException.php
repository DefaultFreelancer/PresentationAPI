<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class APIException extends Exception {

    const GENERAL           = 100;
    const VALIDATION        = 101;
    const NOT_FOUND         = 102;
    const LOGIN_FAILED      = 103;
    const UNAUTHORIZED      = 104;
    const FORBIDDEN         = 105;

    /**
     * https://httpstatuses.com/
     */

    private $APIErrors = [
        APIException::GENERAL => [
            'httpCode' => 500, // Internal Server Error
            'description' => 'Take a break. Something went wrong. If this message repeats contact administrator.',
        ],
        APIException::VALIDATION => [
            'httpCode' => 400, // Bad Request
            'description' => 'Request validation failed.',
        ],
        APIException::NOT_FOUND => [
            'httpCode' => 404, // Not Found
            'description' => 'Resource not found',
        ],
        APIException::LOGIN_FAILED => [
            'httpCode' => 401, // Unauthorized
            'description' => 'Wrong username or password.',
        ],

        APIException::UNAUTHORIZED => [
            'httpCode' => 401, // Unauthorized
            'description' => 'No valid authentication credentials.',
        ],
        APIException::FORBIDDEN => [
            'httpCode' => 403, // Forbidden
            'description' => 'Access denied.',
        ]
    ];

    private $traceId = null;

    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function getHttpCode(){

        if(isset($this->APIErrors[$this->getCode()]['httpCode'])){
            return $this->APIErrors[$this->getCode()]['httpCode'];
        }

        return $this->APIErrors[0]['httpCode'];
    }

    public function getCodeDescription(){
        if(isset($this->APIErrors[$this->getCode()]['description'])){
            return $this->APIErrors[$this->getCode()]['description'];
        }

        return $this->APIErrors[0]['description'];
    }

    public function getResponse(){

        $data = [
            'message' => $this->getMessage(),
            'type' => 'APIException',
            'code' => $this->getCode(),
            'codeDescription' => $this->getCodeDescription(),
        ];

        if ($this->getPrevious()) {
            // ValidationException
            if ($this->getPrevious() instanceof ValidationException) {
                $data['subType'] = 'ValidationException';
                $data['validation'] = [
                    'message' => $this->getPrevious()->getMessage(),
                    'errors' => $this->getPrevious()->errors(),
                ];
            }
        } // if previous

        // Trace id
        if($this->traceId){
            $data['traceId'] = $this->traceId;
        }

        return new JsonResponse($data, $this->getHttpCode());
    }

    public function setTraceId($traceId){
        $this->traceId = $traceId;
    }
}

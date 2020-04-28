<?php
/**
 * Cornerstone API Response
 *
 * @copyright Copyright (c) 2020, Phillips Data, Inc.
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package cornerstone_api
 */
class CornerstoneApiResponse
{
    /**
     * @var string The parsed response from the API
     */
    private $response;
    /**
     * @var string The raw response from the API
     */
    private $raw;

    /**
     * Initializes the Cornerstone Response
     *
     * @param string $response The raw response data from an API request
     */
    public function __construct($response)
    {
        $this->raw = $response;

        parse_str($this->raw, $this->response);

        $this->response = (object) $this->response;
    }

    /**
     * Returns the gateway response
     *
     * @return stdClass A stdClass object representing the gateway response result, null if invalid response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Returns the status of the API Responses
     *
     * @return string The status (approved, declined, error, null = invalid responses)
     */
    public function status()
    {
        if ($this->response && isset($this->response->response)) {
            switch ($this->response->response) {
                case 1:
                    return 'approved';
                    break;
                case 2:
                    return 'declined';
                    break;
                case 3:
                    return 'error';
                    break;
            }
        }
        return null;
    }

    /**
     * Returns all errors contained in the response
     *
     * @return stdClass A stdClass object representing the errors in the response, false if invalid response
     */
    public function errors()
    {
        if ($this->response && $this->response->response == ERROR) {
            return (object) [
                'response' => $this->response->response,
                'responsetext' => $this->response->responsetext,
                'response_code' => $this->response->response_code
            ];
        }
        return false;
    }

    /**
     * Returns the raw response
     *
     * @return string The raw response
     */
    public function raw()
    {
        return $this->raw;
    }
}

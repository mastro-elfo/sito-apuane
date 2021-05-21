<?php

// Risposta standard per le richieste HTTP andate a buon fine.
define("HTTP_OK", 200);
// Errore generico
define("HTTP_BAD_REQUEST", 400);
// Non autorizzato
define("HTTP_UNAUTHORIZED", 401);
// Not found
define("HTTP_NOT_FOUND", 404);
// Internal Server Error
define("HTTP_INTERNAL_SERVER_ERROR", 500);
// Not Implemented
define("HTTP_NOT_IMPLEMENTED", 501);
// Service Unavailable
define("HTTP_SERVICE_UNAVAILABLE", 503);

class Controller
{
    public function action($action, $args)
    {
        if (method_exists($this, $action)) {
            try {
              $this->$action($args);
            }
            catch (Exception $e) {
              $this->error(HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->error(HTTP_NOT_IMPLEMENTED);
        }
    }

    protected function error($code = HTTP_INTERNAL_SERVER_ERROR)
    {
        http_response_code($code);
    }

    protected function response($content, $code = HTTP_OK)
    {
        http_response_code($code);
        echo $content;
    }

    protected function json($content, $code = HTTP_OK)
    {
        return $this->response(json_encode($content), $code);
    }
}

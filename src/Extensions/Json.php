<?php

namespace App\Extensions;

class Json {
    /**
     * Encode data into a JSON response with an optional message.
     *
     * @param string $message
     * @param mixed $data
     * @return string
     */
    public static function encode(string $message, $data = null): string {
        header("Content-type: application/json");
        $response = [
            'success' => true,
            'message' => $message
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Return a JSON response with a failure message.
     *
     * @param string $message
     * @return string
     */
    public static function message(string $message): string {
        header("Content-type: application/json");
        $response = [
            'success' => true,
            'message' => $message
        ];

        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Return a JSON response with only data and no message.
     *
     * @param mixed $data
     * @return string
     */
    public static function data($data): string {
        header("Content-type: application/json");
        $response = [
            'success' => true,
            'data' => $data
        ];

        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Return a generic JSON error response.
     *
     * @return string
     */
    public static function error($message = "Bir hata meydana geldi"): string {
        header("Content-type: application/json");
        $response = [
            'success' => false,
            'message' => $message
        ];

        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Return a JSON response with a custom status.
     *
     * @param bool $success
     * @param string $message
     * @param mixed|null $data
     * @return string
     */
    public static function custom(bool $success, string $message, $data = null): string {
        header("Content-type: application/json");
        $response = [
            'success' => $success,
            'message' => $message
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
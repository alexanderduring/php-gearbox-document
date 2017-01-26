<?php

namespace Gearbox\Document;

class Document
{
    private $data = array();



    public function __construct(array $data)
    {
        $this->data = $data;
    }



    /**
     * Unsets a field in the document, if it exists.
     *
     * @param array $keys
     * @return boolean
     */
    protected function delete($keys)
    {
        $level = &$this->data;
        $lastKey = array_pop($keys);
        $success = true;

        foreach ($keys as $key) {
            if (array_key_exists($key, $level)) {
                if (!is_array($level[$key])) {
                    $success = false;
                    break;
                }
                $level = &$level[$key];
            } else {
                $success = false;
                break;
            }
        }

        if ($success) {
            unset($level[$lastKey]);
        }

        return $success;
    }
}
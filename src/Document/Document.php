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
     * Returns true if a field exists in the document.
     *
     * @param array $keys
     * @return boolean
     */
    public function has($keys)
    {
        if (is_array($keys) && count($keys) > 0) {
            $level = &$this->data;
            $lastKey = array_pop($keys);
            $hasField = true;

            foreach ($keys as $key) {
                if (array_key_exists($key, $level)) {
                    if (!is_array($level[$key])) {
                        $hasField = false;
                        break;
                    }
                    $level = &$level[$key];
                } else {
                    $hasField = false;
                    break;
                }
            }

            if ($hasField && !array_key_exists($lastKey, $level)) {
                $hasField = false;
            }
        } else {
            $hasField = false;
        }

        return $hasField;
    }



    /**
     * Unsets a field in the document, if it exists.
     *
     * @param array $keys
     * @return boolean
     */
    public function delete($keys)
    {
        if (is_array($keys) && count($keys) > 0) {

            $level = &$this->data;
            $keyNotFound = false;
            $lastKey = array_pop($keys);

            foreach ($keys as $key) {
                if (is_array($level) && array_key_exists($key, $level)) {
                    $level = &$level[$key];
                } else {
                    $keyNotFound = true;
                    break;
                }
            }

            if (!$keyNotFound && is_array($level) && array_key_exists($lastKey, $level)) {
                unset($level[$lastKey]);
            }
        }
    }



    public function toArray()
    {
        return $this->data;
    }
}
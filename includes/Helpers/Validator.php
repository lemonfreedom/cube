<?php

namespace Helpers;

class Validator
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $rules = [];

    /**
     * @var null|array
     */
    public $result = null;

    /**
     * @param array $data
     * @param array $rules
     * @return void
     */
    public function __construct($data, $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    /**
     * @param string $value
     * @return bool
     */
    private function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string $value
     * @return bool
     */
    private function required($value)
    {
        return $value !== '';
    }

    /**
     * @return bool|array
     */
    public function run()
    {
        if ($this->result === null) {
            $this->result = [];

            foreach ($this->rules as $key => $rule) {
                foreach ($rule as $r) {
                    $value = $this->data[$key] ?? '';

                    if ($r['type'] === 'custom') {
                        call_user_func($r['validator'], $r, $value, function ($msg = null) use ($key) {
                            if ($msg !== null) {
                                $this->result[] = ['key' => $key, 'message' => $msg];
                            }
                        });
                    } else {
                        if (!$this->{$r['type']}($value)) {
                            $this->result[] = ['key' => $key, 'message' => $r['message']];
                        }
                    }
                }
            }
        }

        return count($this->result) === 0;
    }
}

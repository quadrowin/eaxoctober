<?php namespace Quadrowin\EaxOctober\Classes;

/**
 *
 * @author shvedov_u
 */
class InputFilter
{

    const INPUT_ARRAY = 'array';

    const INPUT_BOOL = 'bool';

    const INPUT_DATE = 'date';

    const INPUT_DATETIME = 'datetime';

    const INPUT_INT = 'int';

    /**
     * Число. Если пустая строка, то null.
     */
    const INPUT_INT_NULL = 'int_null';

    const INPUT_FLOAT = 'float';

    const INPUT_FLOAT_NULL = 'float_null';

    /**
     * То же что и float_null, но могут присутствовать разделители разрядов
     */
    const INPUT_FORMATTED_FLOAT_NULL = 'formatted_float_null';

    const INPUT_STRING = 'string';

    /**
     * Строка, к которой будет применена функция trim()
     */
    const INPUT_TRIM = 'trim';

    /**
     * Разделение строк запятым, точками с запятой, переносами строк, пробелами
     */
    const INPUT_STRING_EXPLODE = 'str_exp';

    /**
     * Массив чисел.
     * Числа могут быть переданы одним из следующих способов:
     * 1) Как массив значений.
     * 2) Как строка чисел, разделенных пробелами, табами, переносами строк, запятыми или точками с запятой.
     * 3) Как json-строка, содержащая массив.
     * В противном случае возвращается пустой массив
     */
    const INPUT_ANY_INT_ARRAY = 'any_int_arr';

    /**
     * @param string|int|string[] $input Разделение строк запятым, точками с запятой, переносами строк, пробелами
     * @return string[]
     */
    public function explodeString($input)
    {
        if (!is_array($input)) {
            $input = preg_split('#[;,\s]#', $input);
        }
        return array_unique(array_filter($input, 'strlen'));
    }

    /**
     * @param mixed $input
     * @param array $params
     * @return InputFilterResult
     */
    public function filter($input, array $params)
    {
        $src = null;
        if ($input instanceof InputFilterSourceInterface) {
            $src = $input;
        } elseif (is_object($input)) {
            $src = new InputFilterSourceObject($input);
        } elseif (is_array($input)) {
            $src = new InputFilterSourceArray($input);
        }
        $output = new InputFilterResult();

        $self = $this;
        $conversions = array(
            self::INPUT_ARRAY => function ($val) {
                return $val && is_array($val) ? $val : [];
            },
            self::INPUT_BOOL => function ($val) {
                return (bool)$val;
            },
            self::INPUT_DATE => function ($val) use ($self) {
                return $self->fixInputDate($val);
            },
            self::INPUT_DATETIME => function ($val) {
                $val = trim($val);
                if ($val === '0000-00-00 00:00:00') {
                    return $val;
                }
                $val = strtotime($val);
                if (!$val) {
                    return null;
                }
                $val = date('Y-m-d H:i:s', $val);
                if (0 === strpos($val, '-')) {
                    $val = substr($val, 1);
                }
                return $val;
            },
            self::INPUT_FLOAT => function ($val) {
                return (float)str_replace(',', '.', $val);
            },
            self::INPUT_FLOAT_NULL => function ($val) {
                return strlen($val) > 0 ? (float)str_replace(',', '.', $val) : null;
            },
            self::INPUT_FORMATTED_FLOAT_NULL => function ($val) {
                $val = preg_replace('#[\s\'`]+#u', '', $val);
                if (strlen($val) < 1) {
                    return null;
                }
                return (float)str_replace(',', '.', $val);
            },
            self::INPUT_INT => function ($val) {
                return (int)$val;
            },
            self::INPUT_INT_NULL => function ($val) {
                return strlen($val) > 0 ? (int)$val : null;
            },
            self::INPUT_STRING => function ($val) {
                return (string)$val;
            },
            self::INPUT_TRIM => function ($val) {
                return trim((string)$val);
            },
            self::INPUT_STRING_EXPLODE => function ($val) use ($self) {
                return $self->explodeString($val);
            },
            self::INPUT_ANY_INT_ARRAY => function ($val) use ($self) {
                return $self->parseAnyIntArray($val);
            },
        );

        foreach ($params as $name => $param) {
            $val = $src->getInputValue($name);
            if ($param instanceof \Closure) {
                $output->{$name} = $param($val);
                continue;
            }
            $rule = is_string($param) ? $param : $param[0];
            if (null === $val && is_array($param) && count($param) > 1) {
                $output->{$name} = $param[1];
                continue;
            }
            $output->{$name} = $conversions[$rule]($val);
        }
        return $output;
    }

    /**
     * @param string|int $value
     * @return string "Y-m-d"
     */
    public function fixInputDate($value)
    {
        return date('Y-m-d', strtotime(trim($value)));
    }

    /**
     * @param string|int $value
     * @return string "Y-m-d H:i:s"
     */
    public function fixInputDateTime($value)
    {
        return date('Y-m-d H:i:s', strtotime(trim($value)));
    }

    /**
     * @param mixed $val
     * @return int[]
     */
    public function parseAnyIntArray($val)
    {
        if (is_numeric($val)) {
            return [(int)$val];
        } elseif (is_string($val)) {
            // разбирает в том числе JSON-строку
            $val = preg_split('#[\[;,\s\]]+#', $val);
            $val = array_filter($val, 'strlen');
        } elseif (!is_array($val)) {
            return [];
        }
        return array_map('intval', array_values($val));
    }

}
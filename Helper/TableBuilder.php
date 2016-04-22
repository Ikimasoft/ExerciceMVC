<?php
namespace Helper;

/**
 * Class TableBuilder
 * @package Helper
 * @author Yann Le Scouarnec <yann.le-scouarnec@hetic.net>
 */
class TableBuilder
{
    /**
     * @var array
     */
    private static $maxLength = [];
    /**
     * String
     */
    const TABLE_CORNER = "+";
    /**
     * String
     */
    const TABLE_HORIZONTAL_LINE = "-";
    /**
     * String
     */
    const TABLE_VERTICAL_LINE = "|";

    /**
     * @param array $data
     * @param array $headers
     * @throws \Exception if $data is not an array
     */
    public static function init($data, $headers = null)
    {
        if (!is_array($data)) {
            throw new \Exception('Oops, no data to build a table with :(');
        }
        // get field count
        $fieldCount = count(current($data));
        // get max length per field
        $maxLength = [];
        if (!is_null($headers) && is_array($headers)) {
            $data = array_merge([$headers], $data);
        }
        // build column max length array
        foreach ($data as $record) {
            $i = 0;
            if (is_array($record)) {
                foreach ($record as $field) {
                    if (!isset($maxLength[$i]) || $maxLength[$i] < mb_strlen($field)) {
                        $maxLength[$i] = mb_strlen($field);
                    }
                    $i++;
                }
            }
        }
        // declare $output string
        $output = '';
        $tableLine = '';
        // add 1 character for cosmetic reasons
        foreach ($maxLength as $index => $count) {
            $maxLength[$index] = $count + 1;
            $tableLine .= self::TABLE_CORNER . str_pad('', $maxLength[$index], self::TABLE_HORIZONTAL_LINE);
        }
        $tableLine .= self::TABLE_CORNER . PHP_EOL;
        $output .= $tableLine;
        foreach ($data as $record) {
            $output .= self::TABLE_VERTICAL_LINE;
            $column = 0;
            foreach ($record as $field) {
                $output .= str_pad($field, $maxLength[$column], ' ').self::TABLE_VERTICAL_LINE;
                $column++;
            }
            $output .= PHP_EOL . $tableLine;
        }
        return $output;
    }

    /**
     *
     */
    private static function drawLine()
    {

    }

}

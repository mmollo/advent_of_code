<?php
$program = explode(',', rtrim(file_get_contents('./input')));

function A(array $program, int $input)
{
    $output = [];
    $pos = 0;
    while (true) {
        $opcode = $program[$pos];
        //echo "$pos -> " . $opcode . PHP_EOL;
        
        if (strlen($opcode) > 1) {
            $mode = array_reverse(str_split(substr($opcode, 0, -2)));
            $opcode = (string)(int)substr($opcode, -2);
        } else {
            $mode = array_fill(0, 3, '0');
        }

        switch ($opcode) {
            case '1':
            case '2':

                $param1 = $program[$pos+1];
                $param2 = $program[$pos+2];

                if (!isset($mode[0]) || $mode[0] === '0') {
                    $param1 = $program[$param1];
                }
                if (!isset($mode[1]) || $mode[1] === '0') {
                    $param2 = $program[$param2];
                }

                if ('1' === $opcode) {
                    $program[$program[$pos+3]] = $param1 + $param2;
                } elseif ('2' === $opcode) {
                    $program[$program[$pos+3]] = $param1 * $param2;
                }
                $pos += 4;
                break;
            case '3':
                $program[$program[$pos+1]] = $input;
                $pos += 2;
                break;
            case '4':
                $output = $program[$program[$pos+1]];
                $pos += 2;
                break;
            case '5':
                $param1 = $program[$pos+1];
                $param2 = $program[$pos+2];
                if (!isset($mode[0]) || $mode[0] === '0') {
                    $param1 = $program[$param1];
                }
                if (!isset($mode[1]) || $mode[1] === '0') {
                    $param2 = $program[$param2];
                }
                if ('0' !== $param1) {
                    $pos = (int)$param2;
                } else {
                    $pos += 3;
                }
                
                break;
            case '6':
                $param1 = $program[$pos+1];
                $param2 = $program[$pos+2];
                if (!isset($mode[0]) || $mode[0] === '0') {
                    $param1 = $program[$param1];
                }
                if (!isset($mode[1]) || $mode[1] === '0') {
                    $param2 = $program[$param2];
                }
                if ('0' === $param1) {
                    $pos = (int)$param2;
                } else {
                    $pos += 3;
                }
                break;
            case '7':
                $param1 = $program[$pos+1];
                $param2 = $program[$pos+2];
                if (!isset($mode[0]) || $mode[0] === '0') {
                    $param1 = $program[$param1];
                }
                if (!isset($mode[1]) || $mode[1] === '0') {
                    $param2 = $program[$param2];
                }
                if ((int)$param1 < (int)$param2) {
                    $program[$program[$pos+3]] = '1';
                } else {
                    $program[$program[$pos+3]] = '0';
                }
                $pos += 4;
                break;
            case '8':
                $param1 = $program[$pos+1];
                $param2 = $program[$pos+2];
                if (!isset($mode[0]) || $mode[0] === '0') {
                    $param1 = $program[$param1];
                }
                if (!isset($mode[1]) || $mode[1] === '0') {
                    $param2 = $program[$param2];
                }
                if ((int)$param1 === (int)$param2) {
                    $program[$program[$pos+3]] = '1';
                } else {
                    $program[$program[$pos+3]] = '0';
                }
                $pos += 4;
                break;
            case '99':
                return $output;
            default:
                throw new Exception("Invalid opcode : " . $program[$pos]);
        }
    }
}


$result = A($program, 1);
echo "Part 1 : " . $result. PHP_EOL;

$result = A($program, 5);
echo "Part 2 : " . $result. PHP_EOL;

<?php

class VM
{
    public static $opcodes = [
        'addr', 'addi',
        'banr', 'bani',
        'borr', 'bori',
        'eqri', 'eqir', 'eqrr',
        'gtir', 'gtri', 'gtrr',
        'muli', 'mulr',
        'seti', 'setr'
    ];
    
    
    private $registers = [];

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->registers = array_fill(0, 4, 0);
        return $this;
    }
    
    public function setRegisters(array $registers)
    {
        $this->registers = $registers;
        return $this;
    }
    
    public function getRegisters()
    {
        return $this->registers;
    }


    public function addr(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a] + $this->registers[$b];
        return $this;
    }

    public function addi(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a] + $b;
        return $this;
    }

    public function mulr(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a] * $this->registers[$b];
        return $this;
    }
    public function muli(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a] * $b;
        return $this;
    }
    public function banr(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a] & $this->registers[$b];
        return $this;
    }
    public function bani(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a] & $b;
        return $this;
    }
    public function borr(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a] | $this->registers[$b];
        return $this;
    }
    public function bori(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a] | $b;
        return $this;
    }

    public function setr(int $a, int $b, int $c) {
        $this->registers[$c] = $this->registers[$a];
        return $this;
    }
    public function seti(int $a, int $b, int $c) {
        $this->registers[$c] = $a;
        return $this;
    }

    public function gtir(int $a, int $b, int $c) {
        if($a > $this->registers[$b]) {
            $this->registers[$c] = 1;
        } else {
            $this->registers[$c] = 0;
        }
        return $this;
    }
    public function gtri(int $a, int $b, int $c) {
        if($this->registers[$a] > $b) {
            $this->registers[$c] = 1;
        } else {
            $this->registers[$c] = 0;
        }
        return $this;
    }
    public function gtrr(int $a, int $b, int $c) {
        if($this->registers[$a] > $this->registers[$b]) {
            $this->registers[$c] = 1;
        } else {
            $this->registers[$c] = 0;
        }
        return $this;
    }

    public function eqir(int $a, int $b, int $c) {
        if($a === $this->registers[$b]) {
            $this->registers[$c] = 1;
        } else {
            $this->registers[$c] = 0;
        }
        return $this;
    }
    public function eqri(int $a, int $b, int $c) {
        if($this->registers[$a] === $b) {
            $this->registers[$c] = 1;
        } else {
            $this->registers[$c] = 0;
        }
        return $this;
    }
    public function eqrr(int $a, int $b, int $c) {
        if($this->registers[$a] === $this->registers[$b]) {
            $this->registers[$c] = 1;
        } else {
            $this->registers[$c] = 0;
        }
        return $this;
    }
}

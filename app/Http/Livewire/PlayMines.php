<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PlayMines extends Component
{
    public $mines;
    public $openedBox = [];
    public $minesCount = 7;
    public $gameStart = false;
    public $gameOver = false;

    public function mount()
    {
        $numbers = range(1, 25);
        shuffle($numbers);
        $this->mines = array_slice($numbers, 0, $this->minesCount);
    }

    public function reload()
    {
        $this->openedBox = [];
        $numbers = range(1, 25);
        shuffle($numbers);
        $this->mines = array_slice($numbers, 0, $this->minesCount);
        $this->gameOver = false;
    }  

    public function open($i)
    {

        if(!$this->gameOver) {
            $this->openedBox[] = $i;
        }

        if(in_array($i, $this->mines)){
            $this->gameOver = true;
        }

    }

    public function render()
    {
        return view('livewire.play-mines');
    }
}

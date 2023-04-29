<?php

namespace App\Http\Livewire;

use Livewire\Component;

use function PHPUnit\Framework\isFalse;

class PlayMines extends Component
{
    public $mines;
    public $openedBox = [];
    public $mineCount = 4;
    public $gameStart = false;
    public $gameOver = false;

    public $rewards = [
        '4'=> [
            '1' => '1.13',
            '2' => '1.35',
            '3' => '1.64',
            '4' => '2',
            '5' => '2.48',
            '6' => '3.1',
            '7' => '3.92',
            '8' => '5.04',
            '9' => '6.6',
            '10' => '8.8',
            '11' => '12',
            '12' => '16.8',
            '13' => '24.27',
            '14' => '36.41',
            '15' => '57.22',
            '16' => '95.37',
            '17' => '171.67',
            '18' => '343.35',
            '19' => '801.16',
            '20' => '2400', 
            '21' => '12020',           
        ]
        ];

    public function mount()
    {
        $numbers = range(1, 25);
        shuffle($numbers);
        $this->mines = array_slice($numbers, 0, $this->mineCount);
    }

    public function reload()
    {
        $this->emit('reload');
        $this->openedBox = [];
        $numbers = range(1, 25);
        shuffle($numbers);
        $this->mines = array_slice($numbers, 0, $this->mineCount);
        $this->gameOver = false;
    }  

    public function open($i)
    {
        if($this->gameOver) {
            return false;
        }

        $this->openedBox[] = $i;
        
        if(in_array($i, $this->mines)){
            $this->gameOver = true;
            $this->emit('gameOver');
            return false;
        }

        $this->emit('openDiamond', count($this->openedBox));
        return true;    

    }

    public function render()
    {
        return view('livewire.play-mines');
    }
}

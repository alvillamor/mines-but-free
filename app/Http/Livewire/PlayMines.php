<?php

namespace App\Http\Livewire;

use Livewire\Component;

use function PHPUnit\Framework\isFalse;

class PlayMines extends Component
{
    public $money = 1000;
    public $mines;
    public $cashout = 0;
    public $openedBox = [];
    public $mineCount = 4;
    public $gameStart = false;
    public $gameOver = false;
    public $bet = 10;

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
        ],
        '5'=> [
            '1' => '1.18',
            '2' => '1.5',
            '3' => '1.91',
            '4' => '2.48',
            '5' => '3.25',
            '6' => '4.34',
            '7' => '5.89',
            '8' => '8.15',
            '9' => '11.55',
            '10' => '16.8',
            '11' => '25.21',
            '12' => '39.21',
            '13' => '63.72',
            '14' => '109.25',
            '15' => '200.29',
            '16' => '400.58',
            '17' => '901.31',
            '18' => '2400',
            '19' => '8410',
            '20' => '50470',           
        ]        

        ];

    public function updatedBet($value)
    {
        if($value < 1) {
            $this->bet = 10;
            return;
        }

        if($value > 20000) {
            $this->bet = 20000;
            return;
        }        

        if($value > $this->money) {
            $this->bet = $this->money;
            return;
        }        

    }

    public function mount()
    {
        $numbers = range(1, 25);
        shuffle($numbers);
        $this->mines = array_slice($numbers, 0, $this->mineCount);
    }

    public function getFormattedMoney()
    {
        return number_format($this->money);
    }

    public function getFormattedCashout()
    {
        return number_format($this->cashout);
    }
 
    public function bet()
    {
        $this->dispatchBrowserEvent('close');
        if($this->money > 0) {
            $this->money -= $this->bet;
            $this->reload();
        }
    }

    public function cashout()
    {
        $this->gameStart = false;
        $data['status'] = "win";
        $data['reward'] = $this->rewards[$this->mineCount][count($this->openedBox)] . "x";
        $data['cashout'] = "+ " .$this->getFormattedCashout();
        $data['color'] = 'text-green-500';
        $this->dispatchBrowserEvent('notify', $data);
        $this->money = $this->money + $this->cashout;
        $this->cashout = 0;
    }

    public function recharge()
    {
        $this->money = 1000;
        $this->bet = 10;
    }
    public function reload()
    {
        $this->emit('reload');
        $this->openedBox = [];
        $numbers = range(1, 25);
        shuffle($numbers);
        $this->mines = array_slice($numbers, 0, $this->mineCount);
        $this->gameStart = true;
        $this->gameOver = false;
    }  


    public function open($i)
    {
        if($this->gameOver == true || $this->gameStart == false) {
            return false;
        }

        $this->openedBox[] = $i;
        
        if(in_array($i, $this->mines)){
            $this->gameOver();
            return false;
        }

        $this->cashout = $this->bet * $this->rewards[$this->mineCount][count($this->openedBox)];
        $this->emit('openDiamond', count($this->openedBox));
        return true;    

    }

    public function gameOver()
    {
        $this->gameOver = true;
        $this->gameStart = false;
        $this->emit('gameOver');
        
        if($this->bet > $this->money) {
            $this->bet = $this->money;
        }

        $data['status'] = "lose";
        $data['reward'] = "0x";
        $data['cashout'] = "+ 0";
        $data['color'] = 'text-red-500';
        $this->dispatchBrowserEvent('notify', $data);

        $this->cashout = 0;
    }

    public function render()
    {
        return view('livewire.play-mines');
    }
}

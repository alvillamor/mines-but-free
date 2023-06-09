<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Record;
use Faker\Generator as Faker;

class Play extends Component
{
    public $money = 1000;

    public $name;
    public $avatarIndex;    
    public $avatarList = [
        'red.png', 'blue.png', 'invoker.webp', 'bounty.webp', 'alchemist.png', 'techies.png'
    ];
    
    public $mines;
    public $cashout = 0;
    public $openedBox = [];
    public $mineCount = 4;
    public $gameStart = false;
    public $gameOver = false;
    public $bet = 10;
    public $gameOverCount = 0;
    public $gameStatus;

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
        ],
        '6'=> [
            '1' => '1.25',
            '2' => '1.66',
            '3' => '2.25',
            '4' => '3.1',
            '5' => '4.34',
            '6' => '6.2',
            '7' => '9.06',
            '8' => '13.59',
            '9' => '21',
            '10' => '33.61',
            '11' => '56.02',
            '12' => '98.04',
            '13' => '182.08',
            '14' => '364.16',
            '15' => '801.17',
            '16' => '2000',
            '17' => '6001',
            '18' => '24004',
            '19' => '168000'         
        ],
        '7'=> [
            '1' => '1.31',
            '2' => '1.86',
            '3' => '2.67',
            '4' => '3.92',
            '5' => '5.89',
            '6' => '9.06',
            '7' => '14.34',
            '8' => '23.48',
            '9' => '39.91',
            '10' => '70.9',
            '11' => '133.06',
            '12' => '266.12',
            '13' => '576.59',
            '14' => '1380',
            '15' => '3810',
            '16' => '12690',
            '17' => '57080',
            '18' => '457000',      
        ]                
    ];

    public function mount(Faker $faker)
    {
        $this->name = $faker->firstName;
        $this->avatarIndex = rand(0, count($this->avatarList) - 1);

        $numbers = range(1, 25);
        shuffle($numbers);
        $this->mines = array_slice($numbers, 0, $this->mineCount);        
    }

    public function updatedBet($value)
    {
        if($value < 1) {
            $this->bet = 10;
            return;
        }

        if($value > 20000 && $this->money > 20000) {
            $this->bet = 20000;
        } elseif($value > 20000 ) {
            $this->bet = $this->money;
        }

    }

    public function formatMoney()
    {
        return number_format($this->money);
    }

    public function formatCashout()
    {
        return number_format($this->cashout);
    }

    public function max()
    {
        if($this->gameStart) {
            return false;
        }
        
        $this->bet = $this->money > 20000 ? 20000 : $this->money;
    }

    public function min()
    {
        if($this->gameStart) {
            return false;
        }
                
        $this->bet = 1;
    }
    public function bet()
    {
        $this->gameStatus = null;
        $this->dispatchBrowserEvent('close');
        if($this->money > 0) {
            $this->money -= $this->bet;
            $this->reload();
        }
    }

    public function cashout()
    {
        $this->gameStatus = "win";
        $this->gameStart = false;
        $this->gameOver = true;
        
        $data['status'] = "win";
        $data['reward'] = $this->rewards[$this->mineCount][count($this->openedBox)] . "x";
        $data['cashout'] = "+ " . $this->cashout;
        $data['color'] = 'text-green-500';

        Record::create([
            'name' => $this->name,
            'status' => $this->gameStatus,
            'avatar' => $this->avatarList[$this->avatarIndex],
            'cashout' => $this->cashout,
            'multiplier' => $this->rewards[$this->mineCount][count($this->openedBox)],      
            'bet' => $this->bet,
        ]);

        $this->emitTo('records', '$refresh');
                
        $this->dispatchBrowserEvent('notify', $data);
        $this->money = $this->money + $this->cashout;
        $this->cashout = 0;
        $this->emit('cashout');        
    }

    public function recharge()
    {
        $this->dispatchBrowserEvent('close');        
        $this->money = 1000 * $this->gameOverCount;
        $this->bet = 10;
        $this->openedBox = [];
        $this->gameStart = false;
        $this->gameOver = false;        
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


    public function changeAvatar()
    {
        $this->avatarIndex++;
        if($this->avatarIndex >= count($this->avatarList)) {
            $this->avatarIndex = 0;
        }
    }

    public function gameOver()
    {
        $this->gameStatus = "lose";
        $this->gameOver = true;
        $this->gameStart = false;
        $this->gameOverCount++;
        $this->emit('gameOver');
        
        Record::create([
            'name' => $this->name,
            'status' => $this->gameStatus,
            'avatar' => $this->avatarList[$this->avatarIndex],
            'cashout' => 0,
            'multiplier' => $this->rewards[$this->mineCount][count($this->openedBox)],
            'bet' => $this->bet,
        ]);

        $this->emitTo('records', '$refresh');
        
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
        return view('livewire.play');
    }
}

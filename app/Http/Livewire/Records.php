<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Record;

class Records extends Component
{
    public $records;
    public $filter = "recent";

    protected $listeners = [
        '$refresh'
    ];

    public function render()
    {
        if($this->filter == "recent") {
            $this->records = Record::orderBy('created_at', 'desc')->limit(12)->get();
        } else {
            $this->records = Record::orderBy('cashout', 'desc')->limit(12)->get();
        }
        return view('livewire.records');
    }
}

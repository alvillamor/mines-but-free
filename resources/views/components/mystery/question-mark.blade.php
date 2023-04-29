<div wire:click="open({{ $i }})" class="z-10 w-full h-full text-[2.75rem] font-black absolute leading-none cursor-pointer shadow-[0_3px_0px_1px_#1e3a8a] p-2 mystery-box flex items-center justify-center bg-blue-700 text-blue-400 rounded-lg border-yellow-900 ">
    @if(!$this->gameOver)
        ?
    @else
        @if(in_array($i, $mines))
            <x-mystery.image.mine />
        @else
            <x-mystery.image.diamond />
        @endif
    @endif
</div>
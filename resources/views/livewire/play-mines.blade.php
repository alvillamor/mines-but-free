<div>
    <div class="flex justify-center gap-x-8">
            <div class="max-w-sm w-full">
                <div class="flex justify-between gap-x-4 mb-1">
                    <h3 class="font-bold sm:text-[2rem] text-[1.75rem] text-center flex items-center justify-center gap-x-2">
                        <span class="block text-red-600 drop-shadow-[0px_0px_1px_#991b1b]">MINES</span> 
                        <span class="sm:text-3xl text-xl drop-shadow-[0_3px_0px_1px_#991b1b]">BUT</span>
                        <span class="block text-green-400 drop-shadow-[0px_0px_1px_#15803d]">FREE</span>
                    </h3>
                    <div class="flex items-center">
                        <div class="bg-black flex flex-row items-center justify-between p-2  rounded-lg w-full border-2 border-gray-600 ">
                            <div class="mr-1 w-6">
                                <x-mystery.image.diamond />
                            </div>
                            <div>{{ $this->getFormattedMoney() }}</div>
                        </div>                    
                    </div>
                </div>

                <div class="relative">     
                    <div class="grid grid-cols-5 gap-2.5 mb-5">  
                        @foreach(range(1, 25) as $i)
                            <div class="relative grid-1 h-[4rem]">   

                                @if(!in_array($i, $openedBox))
                                    <x-mystery.question-mark :i="$i" :mines="$mines" />
                                @endif
                                
                                @if(in_array($i, $mines))
                                    <x-mystery.mine />  
                                @else
                                    <x-mystery.diamond />
                                @endif
                            </div>               
                        @endforeach                
                    </div>
                    <div x-data="{ show: false, data: ''}" 
                        x-on:close.window="show = false"                    
                        x-on:notify.window="setTimeout(() => { show = true }, 100); data = $event.detail; setTimeout(() => { show = false }, 3000)" 
                        x-show="show"
                        x-transition:enter.duration.100ms
                        x-transition:leave.duration.100ms         
                        style="display:none;"
                        class="absolute top-0 left-0 h-full w-full z-10  px-14 py-20 box-border">
                        <div class="bg-opacity-70 bg-black h-full w-full rounded-lg flex justify-center gap-y-3 flex-col items-center">
                            <div class="font-bold text-lg uppercase" x-text="data.status"></div>
                            <div class="font-bold text-3xl" :class="data.color" x-text="data.reward"></div>
                            <div class="font-bold text-lg uppercase" x-text="data.cashout"></div>
                        </div>
                    </div>
                </div>
                <div id="hits" class="flex mb-5 gap-x-5 overflow-y-auto pb-2">
                    @foreach($rewards[$mineCount] as $hits => $reward)
                        <div id="hits{{ $hits }}" class="rounded-lg overflow-hidden border-2 {{ count($openedBox) == $hits && !$gameOver ? 'border-green-600 shadow-xl' : ($gameOver && count($openedBox) -1 == $hits ? 'border-red-600' : 'border-gray-600')  }} text-center w-20 shrink-0">
                            <div class="{{ count($openedBox) == $hits && !$gameOver ? 'bg-green-800' : ($gameOver && count($openedBox) -1 == $hits ? 'bg-red-800' : 'bg-gray-800')   }} font-black">{{ $reward }}x</div>
                            <div>{{ $hits }} hits</div>
                        </div>                        
                    @endforeach                                           
                </div>

                <div class="flex gap-x-2 overflow-y-auto pb-2 items-stretch h-20">
                    <div class="relative flex items-center">
                        <x-mystery.image.mine class="w-7 m-2 absolute z-10" />
                        <select {{ $gameStart == true ? 'disabled' : '' }} wire:model="mineCount" class="disabled:text-gray-600 bg-gray-800 font-bold h-full border-red-800 text-gray-200 pl-12 pr-8 align-right rounded-lg border-2 text-sm focus:ring-0 focus:border-red-800 ">
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="bg-gray-800 grow rounded-lg border border-gray-600 relative flex overflow-hidden items-center">
                        <div class="bg-gray-700 w-10 h-full shrink-0 flex items-center justify-center">
                            <x-mystery.image.diamond class="w-7" />
                        </div>
                        <div class="shrink-1 flex flex-col items-center justify-center">
                            <input {{ $gameStart == true ? 'disabled' : '' }} wire:model="bet" class="disabled:text-gray-600 bg-gray-800 text-center text-sm font-black border-0 w-full pl-2 pr-7 justify-center py-0 focus:ring-0" type="number" />
                            <div class="text-gray-500 text-xs pl-2 pr-7">{{ $money }}</div>
                        </div>
                        <button wire:click="min" class="w-10 text-center cursor-pointer absolute uppercase text-gray-400 bg-gray-900 text-[.6rem] rounded-lg top-2 right-1 py-1 px-2">Min</button>                        
                        <button wire:click="max" class="w-10 text-center cursor-pointer absolute uppercase text-gray-400 bg-gray-900 text-[.6rem] rounded-lg bottom-2 right-1 py-1 px-2">Max</button>
                    </div>
                    <div class="sm:w-28 w-20 rounded-lg overflow-hidden shrink-0">
                        @if($gameStart == false)
                            <button wire:click="bet" class="w-full h-full cursor-pointer bg-red-600 text-center font-bold flex text-md items-center justify-center">
                                Bet
                            </button>
                        @else
                            <button wire:click="cashout" {{ $cashout == 0 ? 'disabled' : '' }} class="disabled:bg-gray-600 bg-blue-600 disabled:cursor-not-allowed w-full h-full cursor-pointer text-center flex flex-col gap-y-0 text-md items-center justify-center">
                                <div class="font-bold">Cashout</div>
                                <div class="text-xs">{{ $this->getFormattedCashout() }}</div>
                            </button>                        
                        @endif
                    </div>
                </div>
            </div>               
    </div>
    <p class="mt-1 text-center">
        @if($money == 0 && $gameOver == true)
            No more gold. <span class="cursor-pointer underline" wire:click="recharge()">Recharge another 1,000!</span>   
        @elseif($money > 5000)
            You're on fire! Try your luck with <span class="text-green-600">real money</span> <a target="_blank" href="https://www.pesowin.xyz/c-ViXcYCRz?lang=en" class="underline">here</a>.
        @else
            This site is just for fun with no money involved.
        @endif
    </p>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @this.on('gameOver', () => {
                new Audio("{{ asset('effects/bomb.mpeg')}} ").play();
            })

            @this.on('openDiamond', (hits) => {
                new Audio("{{ asset('effects/diamond.mpeg')}} ").play();
                document.getElementById('hits' + hits).scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });           
            })

            @this.on('reload', () => {
                new Audio("{{ asset('effects/reload.mp3')}} ").play();       
            })    
            @this.on('cashout', () => {
                new Audio("{{ asset('effects/cashout.mpeg')}} ").play();       
            })                                  
        });
    </script>    
</div>

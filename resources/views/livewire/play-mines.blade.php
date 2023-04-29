<div>
    <h3 class="font-bold text-[2.5rem] text-center flex items-center justify-center gap-x-2">
        <span class="block text-red-600 drop-shadow-[0px_0px_1px_#991b1b]">MINES</span> 
        <span class="text-3xl drop-shadow-[0_3px_0px_1px_#991b1b]">BUT</span>
        <span class="block text-green-400 drop-shadow-[0px_0px_1px_#15803d]">FREE</span>
    </h3>

    <div class="flex justify-center gap-x-8">
            <div class="w-20"></div>
            <div class="max-w-md w-full">
                <div class="grid grid-cols-5 gap-2.5 mb-5">  
                    @foreach(range(1, 25) as $i)
                        <div class="relative grid-1 h-[4.75rem]">   

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

                <div id="hits" class="flex mb-5 gap-x-4 overflow-y-auto pb-2">
                    @foreach($rewards[$mineCount] as $hits => $reward)
                        <div id="hits{{ $hits }}" class="rounded-lg overflow-hidden border-2 {{ count($openedBox) == $hits && !$gameOver ? 'border-green-600 shadow-xl' : ($gameOver && count($openedBox) -1 == $hits ? 'border-red-600' : 'border-gray-600')  }} text-center w-20 shrink-0">
                            <div class="{{ count($openedBox) == $hits && !$gameOver ? 'bg-green-800' : ($gameOver && count($openedBox) -1 == $hits ? 'bg-red-800' : 'bg-gray-800')   }} font-black">{{ $reward }}x</div>
                            <div>{{ $hits }} hits</div>
                        </div>                        
                    @endforeach                                           
                </div>
                <button wire:click="reload" class="bg-red-600 font-bold py-3 px-4 text-md rounded-lg">Reload</button>
            </div>
            <div class="w-24"></div>            
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @this.on('gameOver', () => {
                new Audio("{{ asset('effects/gameover.mp3')}} ").play();
            })

            @this.on('openDiamond', (hits) => {
                new Audio("{{ asset('effects/diamond.mp3')}} ").play();
                document.getElementById('hits' + hits).scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });           
            })

            @this.on('reload', () => {
                new Audio("{{ asset('effects/reload.mp3')}} ").play();
                document.getElementById('hits1').scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });           
            })                        
        });
    </script>    
</div>

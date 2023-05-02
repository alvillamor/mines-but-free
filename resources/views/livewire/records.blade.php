<div>
    <table class="w-full text-xs text-left">
        <tr class="border-b border-gray-800">
            <th class="w-auto py-2 text-gray-400">
                <select wire:model="filter" class="text-xs bg-gray-950  rounded-lg">
                    <option value="recent">Recent</option>
                    <option value="top">Top</option>
                </select>
            </th>
            <th class="w-20 py-2 text-gray-400">Multiplier</th>
            <th class="w-24 py-2 text-gray-400">Bet</th>
            <th class="w-24 py-2 text-gray-400">Cashout</th>
        </tr>

        @foreach($records as $record)
            <tr class="text-xs border-b border-gray-800">
                <td class="py-4 text-white flex gap-x-2 items-center">
                    <img class="w-5 h-auto" src="{{ asset('images/player/' . $record->avatar) }}" />
                    <span>{{ $record->name }}</span>
                </td>
                <td class="py-4 text-gray-400"><span class="bg-opacity-80 bg-{{ $record->status_color }}-800 py-[.1rem] px-3 text-{{ $record->status_color }}-400 rounded-lg font-semibold">{{ $record->multiplier }}x</span></td>
                <td class="py-4 text-gray-400 text-red-400"><span class="bg-opacity-80 bg-{{ $record->status_color }}-800 py-[.1rem] px-3 text-{{ $record->status_color }}-400 rounded-lg font-semibold">{{ number_format($record->bet) }}</span></td>
                <td class="py-4 text-gray-400"><span class="bg-opacity-80 bg-{{ $record->status_color }}-800 py-[.1rem] px-3 text-{{ $record->status_color }}-400 rounded-lg font-semibold">{{ $record->status == 'win' ? '+' : '' }}{{ number_format($record->cashout) }}</span></td>
            </tr>
        @endforeach                        
    </table>
</div>

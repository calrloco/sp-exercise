<div class="class flex flex-col items-center justify-end shadow-lg rounded lg:w-1/2 w-full">
    <div class="w-full flex justify-center flex-col items-center bg-slate-100 shadow rounded-t-xl py-5">
        <div class="flex w-full px-8">
            <div class="lg:w-1/3 w-full">
                <label for="from" class="block text-sm font-medium text-gray-700">From</label>
                <select wire:model="from" id="from" name="from"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    @foreach($airports as $airport)
                        @if($airport->code !== $this->to)
                            <option value="{{$airport->code}}">{{$airport->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button class="h-full justify-center items-end flex px-2">
                <span class="flex  justify-center items-center rounded bg-white max-h-[38px] shadow px-2">
                   <x-gmdi-swap-horiz wire:click="swap" class="h-10 w-10 hover:text-slate-600 text-slate-400"/>
                </span>
            </button>
            <div class="lg:w-1/3 w-full">
                <label for="to" class="block text-sm font-medium text-gray-700">To</label>
                <select wire:model="to" id="to" name="to"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    @foreach($airports as $airport)
                        @if($airport->code !== $this->from)
                            <option value="{{$airport->code}}">{{$airport->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="lg:w-1/3 w-full pl-3 text-slate-400 max-w-[160px]">
                <label for="from" class="block text-sm text-gray-700 mb-1">Max stopovers</label>
                <div class="w-full justify-between flex h-[38px] border-slate-200">
                    <div wire:click="decrementStopOvers"
                         class="flex-1   shadow justify-center hover:bg-slate-200 items-center border-r border-r-white rounded-l flex bg-white font-black cursor-pointer">
                        -
                    </div>
                    <div
                        class="h-full px-5 shadow justify-center items-center bg-white flex font-medium min-w-[60px]">{{$stopOvers}}</div>
                    <div wire:click="incrementStopOvers"
                         class="flex-1 shadow justify-center hover:bg-slate-200 rounded-r border-l border-l-white items-center flex bg-white font-black cursor-pointer">
                        +
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full min-h-[310px] bg-white rounded-b-xl">
        <div class="flex h-full justify-center items-center">
            @if(!$flight)
                <div
                    class="mt-5 uppercase font-bold grid place-items-center {{ $flight ? 'opacity-0' : 'opacity-100' }}">
                    <p class="">No results found</p>
                    <p class="text-xs font-light text-slate-800">try with different filters</p>
                </div>
            @endif
            <x-flight-card message="overall best price" :flight="$flight"></x-flight-card>
        </div>
    </div>
</div>
</div>

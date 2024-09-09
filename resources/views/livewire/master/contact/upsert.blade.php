<div>
    <x-slot name="header">Contact Entry</x-slot>

    <!-- Top Controls ------------------------------------------------------------------------------------------------>

    <x-forms.m-panel>

        <x-tabs.tab-panel>

            <x-slot name="tabs">
                <x-tabs.tab>Mandatory</x-tabs.tab>
                <x-tabs.tab>Detailing</x-tabs.tab>
            </x-slot>

            <x-slot name="content">

                <x-tabs.content>

                    <div class="lg:flex-row flex flex-col sm:gap-8 gap-4">

                        <!-- Left area -------------------------------------------------------------------------------->

                        <div class="sm:w-1/2 w-full flex flex-col gap-3 ">

                            <x-input.floating wire:model="vname" label="Name"/>
                            <x-input.floating wire:model="mobile" label="Mobile"/>
                            <x-input.floating wire:model="whatsapp" label="Whatsapp"/>
                            <x-input.floating wire:model="contact_person" label="Contact Person"/>
                            <x-input.floating wire:model="gstin" label="GST No"/>
                            <x-input.floating wire:model="email" label="Email"/>

                        </div>

                        <!-- Right area ------------------------------------------------------------------------------->

                        <div class="lg:w-1/2 flex flex-col gap-3">

                            <div x-data="{
                                    openTab: 0,
                                    activeClasses: 'border-l border-t border-r rounded-t text-blue-700',
                                    inactiveClasses: 'text-blue-500 hover:text-blue-700'
                                }" class="space-y-1">
                                <ul class="flex items-center border-b overflow-x-scroll space-x-2">
                                    <li x-on:click="$wire.sortSearch('{{0}}')" @click="openTab = 0"
                                        :class="{ '-mb-px': openTab === 0 }" class="-mb-px">
                                        <a href="#" :class="openTab === 0 ? activeClasses : inactiveClasses"
                                           class="bg-white inline-block py-3 px-4 font-semibold ">
                                            Primary
                                        </a>
                                    </li>
                                    @foreach($secondaryAddress as $index => $row)
                                        <li @click="openTab = {{$row}}" :class="{ '-mb-px': openTab === {{$row}} }"
                                            class="mr-1 ">
                                            <!-- Set active class by using :class provided by Alpine -->
                                            <div class="inline-flex gap-2 py-2 px-4"
                                                 :class="openTab === {{$row}} ? activeClasses : inactiveClasses">
                                                <a href="#" x-on:click="$wire.sortSearch('{{$row}}')"

                                                   class="bg-white inline-block   font-semibold">
                                                    <span>Secondary</span>
                                                </a>
                                                <button class="hover:text-red-400 pt-1" @click="openTab = {{$row-1}}"
                                                        wire:click="removeAddress('{{$index}}','{{$row}}')">
                                                    <x-icons.icon :icon="'x-mark'" class="block h-4 w-4"/>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="mr-1">
                                        <button :class="inactiveClasses"
                                                class="bg-white inline-block py-2 px-4 font-semibold"
                                                wire:click="addAddress('{{$addressIncrement}}')">
                                            + Add
                                        </button>
                                    </li>
                                </ul>
                                <div class="w-full">
                                    <div x-show="openTab === 0" class="py-2">
                                        <div class="flex flex-col gap-3">

                                            <x-input.floating wire:model.live="itemList.{{0}}.address_1"
                                                              label="Address"/>
                                            <x-input.floating wire:model.live="itemList.{{0}}.address_2"
                                                              label="Area-Road"/>

                                            {{--                                            <x-input.model-text wire:model.live="itemList.{{0}}.address_1"--}}
                                            {{--                                                                :label="'Address'"/>--}}

                                            {{--                                            <x-input.model-text wire:model.live="itemList.{{0}}.address_2"--}}
                                            {{--                                                                :label="'Area-Road'"/>--}}

                                            <x-dropdown.wrapper label="City" type="cityTyped">
                                                <div class="relative ">
                                                    <x-dropdown.input label="City" id="city_name"
                                                                      wire:model.live="itemList.{{0}}.city_name"
                                                                      wire:keydown.arrow-up="decrementCity"
                                                                      wire:keydown.arrow-down="incrementCity"
                                                                      wire:keydown.enter="enterCity"/>
                                                    <x-dropdown.select>
                                                        @if($cityCollection)
                                                            @forelse ($cityCollection as $i => $city)
                                                                <x-dropdown.option
                                                                    highlight="{{$highlightCity === $i  }}"
                                                                    wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}','{{0}}')">
                                                                    {{ $city->vname }}
                                                                </x-dropdown.option>
                                                            @empty
                                                                <x-dropdown.create  wire:click.prevent="citySave('{{ $itemList[0]['city_name'] }}','{{0}}')" label="City" />
                                                            @endforelse
                                                        @endif
                                                    </x-dropdown.select>
                                                </div>
                                            </x-dropdown.wrapper>

                                            {{--                                            <div class="flex flex-row ">--}}
                                            {{--                                                <div class="xl:flex w-full gap-2">--}}
                                            {{--                                                    <label for="city_name"--}}
                                            {{--                                                           class="w-[10rem] text-zinc-500 tracking-wide py-2 ">City</label>--}}
                                            {{--                                                    <div x-data="{isTyped: @entangle('cityTyped')}"--}}
                                            {{--                                                         @click.away="isTyped = false"--}}
                                            {{--                                                         class="w-full">--}}
                                            {{--                                                        <div class="relative">--}}
                                            {{--                                                            <input--}}
                                            {{--                                                                id="city_name"--}}
                                            {{--                                                                type="search"--}}
                                            {{--                                                                wire:model.live="itemList.{{0}}.city_name"--}}
                                            {{--                                                                autocomplete="off"--}}
                                            {{--                                                                placeholder="Choose.."--}}
                                            {{--                                                                @focus="isTyped = true"--}}
                                            {{--                                                                @keydown.escape.window="isTyped = false"--}}
                                            {{--                                                                @keydown.tab.window="isTyped = false"--}}
                                            {{--                                                                @keydown.enter.prevent="isTyped = false"--}}
                                            {{--                                                                wire:keydown.arrow-up="decrementCity"--}}
                                            {{--                                                                wire:keydown.arrow-down="incrementCity"--}}
                                            {{--                                                                wire:keydown.enter="enterCity('{{0}}')"--}}
                                            {{--                                                                class="block w-full rounded-lg "--}}
                                            {{--                                                            />--}}

                                            {{--                                                            <!-- City Dropdown -------------------------------------------------------------------->--}}

                                            {{--                                                            <div x-show="isTyped"--}}
                                            {{--                                                                 x-transition:leave="transition ease-in duration-100"--}}
                                            {{--                                                                 x-transition:leave-start="opacity-100"--}}
                                            {{--                                                                 x-transition:leave-end="opacity-0"--}}
                                            {{--                                                                 x-cloak--}}
                                            {{--                                                            >--}}
                                            {{--                                                                <div class="absolute z-20 w-full mt-2">--}}
                                            {{--                                                                    <div class="block py-1 shadow-md w-full--}}
                                            {{--                rounded-lg border-transparent flex-1 appearance-none border--}}
                                            {{--                                 bg-white text-gray-800 ring-1 ring-purple-600">--}}
                                            {{--                                                                        <ul class="overflow-y-scroll h-96">--}}
                                            {{--                                                                            @if($cityCollection)--}}
                                            {{--                                                                                @forelse ($cityCollection as $i => $city)--}}

                                            {{--                                                                                    <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8--}}
                                            {{--                                                        {{ $highlightCity === $i ? 'bg-yellow-100' : '' }}"--}}
                                            {{--                                                                                        wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}','{{0}}')"--}}
                                            {{--                                                                                        x-on:click="isTyped = false">--}}
                                            {{--                                                                                        {{ $city->vname }}--}}
                                            {{--                                                                                    </li>--}}
                                            {{--                                                                                @empty--}}
                                            {{--                                                                                    <button--}}
                                            {{--                                                                                        wire:click.prevent="citySave('{{ $itemList[0]['city_name'] }}','{{0}}')"--}}
                                            {{--                                                                                        class="text-white bg-green-500 text-center w-full">--}}
                                            {{--                                                                                        create--}}
                                            {{--                                                                                    </button>--}}
                                            {{--                                                                                @endforelse--}}
                                            {{--                                                                            @endif--}}
                                            {{--                                                                        </ul>--}}
                                            {{--                                                                    </div>--}}
                                            {{--                                                                </div>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}

                                            <x-dropdown.wrapper label="State" type="stateTyped">
                                                <div class="relative ">
                                                    <x-dropdown.input label="State" id="state_name"
                                                                      wire:model.live="itemList.{{0}}.state_name"
                                                                      wire:keydown.arrow-up="decrementState"
                                                                      wire:keydown.arrow-down="incrementState"
                                                                      wire:keydown.enter="enterState"/>
                                                    <x-dropdown.select>
                                                        @if($stateCollection)
                                                            @forelse ($stateCollection as $i => $states)
                                                                <x-dropdown.option
                                                                    highlight="{{$highlightState === $i  }}"
                                                                    wire:click.prevent="setState('{{$states->vname}}','{{$states->id}}','{{0}}')">
                                                                    {{ $states->vname }}
                                                                </x-dropdown.option>
                                                            @empty
                                                                <x-dropdown.create wire:click.prevent="stateSave('{{ $itemList[0]['state_name'] }}','{{0}}')" label="State"/>
                                                            @endforelse
                                                        @endif
                                                    </x-dropdown.select>
                                                </div>
                                            </x-dropdown.wrapper>


                                            {{--                                            <div class="flex flex-col ">--}}
                                            {{--                                                <div class="xl:flex w-full gap-2">--}}
                                            {{--                                                    <label for="state_name"--}}
                                            {{--                                                           class="w-[10rem] text-zinc-500 tracking-wide py-2">State</label>--}}
                                            {{--                                                    <div x-data="{isTyped: @entangle('stateTyped')}"--}}
                                            {{--                                                         @click.away="isTyped = false"--}}
                                            {{--                                                         class="w-full">--}}
                                            {{--                                                        <div class="relative">--}}
                                            {{--                                                            <input--}}
                                            {{--                                                                id="state_name"--}}
                                            {{--                                                                type="search"--}}
                                            {{--                                                                wire:model.live="itemList.{{0}}.state_name"--}}
                                            {{--                                                                autocomplete="off"--}}
                                            {{--                                                                placeholder="Choose.."--}}
                                            {{--                                                                @focus="isTyped = true"--}}
                                            {{--                                                                @keydown.escape.window="isTyped = false"--}}
                                            {{--                                                                @keydown.tab.window="isTyped = false"--}}
                                            {{--                                                                @keydown.enter.prevent="isTyped = false"--}}
                                            {{--                                                                wire:keydown.arrow-up="decrementState"--}}
                                            {{--                                                                wire:keydown.arrow-down="incrementState"--}}
                                            {{--                                                                wire:keydown.enter="enterState('{{0}}')"--}}
                                            {{--                                                                class="block w-full rounded-lg"--}}
                                            {{--                                                            />--}}

                                            {{--                                                            <!-- State Dropdown -------------------------------------------------------------------->--}}
                                            {{--                                                            <div x-show="isTyped"--}}
                                            {{--                                                                 x-transition:leave="transition ease-in duration-100"--}}
                                            {{--                                                                 x-transition:leave-start="opacity-100"--}}
                                            {{--                                                                 x-transition:leave-end="opacity-0"--}}
                                            {{--                                                                 x-cloak--}}
                                            {{--                                                            >--}}
                                            {{--                                                                <div class="absolute z-20 w-full mt-2">--}}
                                            {{--                                                                    <div class="block py-1 shadow-md w-full--}}
                                            {{--                                                                    rounded-lg border-transparent flex-1 appearance-none border--}}
                                            {{--                                                                     bg-white text-gray-800 ring-1 ring-purple-600">--}}
                                            {{--                                                                        <ul class="overflow-y-scroll h-96">--}}
                                            {{--                                                                            @if($stateCollection)--}}
                                            {{--                                                                                @forelse ($stateCollection as $i => $states)--}}

                                            {{--                                                                                    <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100--}}
                                            {{--                                                                                    border-b border-gray-300 h-8--}}
                                            {{--                                                                             {{ $highlightState === $i ? 'bg-yellow-100' : '' }}"--}}
                                            {{--                                                                                        wire:click.prevent="setState('{{$states->vname}}','{{$states->id}}','{{0}}')"--}}
                                            {{--                                                                                        x-on:click="isTyped = false">--}}
                                            {{--                                                                                        {{ $states->vname }}--}}
                                            {{--                                                                                    </li>--}}

                                            {{--                                                                                @empty--}}
                                            {{--                                                                                    <button--}}
                                            {{--                                                                                        wire:click.prevent="stateSave('{{ $itemList[0]['state_name'] }}','{{0}}')"--}}
                                            {{--                                                                                        class="text-white bg-green-500 text-center w-full">--}}
                                            {{--                                                                                        create--}}
                                            {{--                                                                                    </button>--}}
                                            {{--                                                                                @endforelse--}}
                                            {{--                                                                            @endif--}}
                                            {{--                                                                        </ul>--}}
                                            {{--                                                                    </div>--}}
                                            {{--                                                                </div>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}

                                            <x-dropdown.wrapper label="Pincode" type="pincodeTyped">
                                                <div class="relative ">
                                                    <x-dropdown.input label="Pincode" id="pincode_name"
                                                                      wire:model.live="itemList.{{0}}.pincode_name"
                                                                      wire:keydown.arrow-up="decrementPincode"
                                                                      wire:keydown.arrow-down="incrementPincode"
                                                                      wire:keydown.enter="enterPincode"/>
                                                    <x-dropdown.select>
                                                        @if($pincodeCollection)
                                                            @forelse ($pincodeCollection as $i => $pincode)
                                                                <x-dropdown.option
                                                                    highlight="{{$pincodeCollection === $i  }}"
                                                                    wire:click.prevent="setPincode('{{$pincode->vname}}','{{$pincode->id}}','{{0}}')">
                                                                    {{ $pincode->vname }}
                                                                </x-dropdown.option>
                                                            @empty
                                                                <x-dropdown.create  wire:click.prevent="pincodeSave('{{$itemList[0]['pincode_name'] }}','{{0}}')" label="Pincode"/>
                                                            @endforelse
                                                        @endif
                                                    </x-dropdown.select>
                                                </div>
                                            </x-dropdown.wrapper>

                                            {{--                                            <div class="flex flex-col ">--}}
                                            {{--                                                <div class="xl:flex w-full gap-2">--}}
                                            {{--                                                    <label for="pincode_name"--}}
                                            {{--                                                           class="w-[10rem] text-zinc-500 tracking-wide py-2">Pincode</label>--}}
                                            {{--                                                    <div x-data="{isTyped: @entangle('pincodeTyped')}"--}}
                                            {{--                                                         @click.away="isTyped = false"--}}
                                            {{--                                                         class="w-full">--}}
                                            {{--                                                        <div class="relative">--}}
                                            {{--                                                            <input--}}
                                            {{--                                                                id="pincode_name"--}}
                                            {{--                                                                type="search"--}}
                                            {{--                                                                wire:model.live="itemList.{{0}}.pincode_name"--}}
                                            {{--                                                                autocomplete="off"--}}
                                            {{--                                                                placeholder="Choose.."--}}
                                            {{--                                                                @focus="isTyped = true"--}}
                                            {{--                                                                @keydown.escape.window="isTyped = false"--}}
                                            {{--                                                                @keydown.tab.window="isTyped = false"--}}
                                            {{--                                                                @keydown.enter.prevent="isTyped = false"--}}
                                            {{--                                                                wire:keydown.arrow-up="decrementPincode"--}}
                                            {{--                                                                wire:keydown.arrow-down="incrementPincode"--}}
                                            {{--                                                                wire:keydown.enter="enterPincode('{{0}}')"--}}
                                            {{--                                                                class="block w-full rounded-lg"--}}
                                            {{--                                                            />--}}

                                            {{--                                                            <!-- Pin-code Dropdown -------------------------------------------------------------------->--}}
                                            {{--                                                            <div x-show="isTyped"--}}
                                            {{--                                                                 x-transition:leave="transition ease-in duration-100"--}}
                                            {{--                                                                 x-transition:leave-start="opacity-100"--}}
                                            {{--                                                                 x-transition:leave-end="opacity-0"--}}
                                            {{--                                                                 x-cloak--}}
                                            {{--                                                            >--}}
                                            {{--                                                                <div class="absolute z-20 w-full mt-2">--}}
                                            {{--                                                                    <div class="block py-1 shadow-md w-full--}}
                                            {{--                rounded-lg border-transparent flex-1 appearance-none border--}}
                                            {{--                                 bg-white text-gray-800 ring-1 ring-purple-600">--}}
                                            {{--                                                                        <ul class="overflow-y-scroll h-96">--}}
                                            {{--                                                                            @if($pincodeCollection)--}}
                                            {{--                                                                                @forelse ($pincodeCollection as $i => $pincode)--}}
                                            {{--                                                                                    <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8--}}
                                            {{--                                                        {{ $highlightPincode === $i ? 'bg-yellow-100' : '' }}"--}}
                                            {{--                                                                                        wire:click.prevent="setPincode('{{$pincode->vname}}','{{$pincode->id}}','{{0}}')"--}}
                                            {{--                                                                                        x-on:click="isTyped = false">--}}
                                            {{--                                                                                        {{ $pincode->vname }}--}}
                                            {{--                                                                                    </li>--}}
                                            {{--                                                                                @empty--}}
                                            {{--                                                                                    <button--}}
                                            {{--                                                                                        wire:click.prevent="pincodeSave('{{$itemList[0]['pincode_name'] }}','{{0}}')"--}}
                                            {{--                                                                                        class="text-white bg-green-500 text-center w-full">--}}
                                            {{--                                                                                        create--}}
                                            {{--                                                                                    </button>--}}

                                            {{--                                                                                @endforelse--}}
                                            {{--                                                                            @endif--}}
                                            {{--                                                                        </ul>--}}
                                            {{--                                                                    </div>--}}
                                            {{--                                                                </div>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}

                                            <x-dropdown.wrapper label="Country" type="countryTyped">
                                                <div class="relative ">
                                                    <x-dropdown.input label="Country" id="country_name"
                                                                      wire:model.live="itemList.{{0}}.country_name"
                                                                      wire:keydown.arrow-up="decrementCountry"
                                                                      wire:keydown.arrow-down="incrementCountry"
                                                                      wire:keydown.enter="enterCountry('{{0}}')"/>
                                                    <x-dropdown.select>
                                                        @if($countryCollection)
                                                            @forelse ($countryCollection as $i => $country)
                                                                <x-dropdown.option
                                                                    highlight="{{$countryCollection === $i  }}"
                                                                    wire:click.prevent="setCountry('{{$country->vname}}','{{$country->id}}','{{0}}')">
                                                                    {{ $country->vname }}
                                                                </x-dropdown.option>
                                                            @empty
                                                                <x-dropdown.create  wire:click.prevent="countrySave('{{$itemList[0]['country_name']}}','{{0}}')" label="Country" />
                                                            @endforelse
                                                        @endif
                                                    </x-dropdown.select>
                                                </div>
                                            </x-dropdown.wrapper>

                                            {{--                                            <div class="flex flex-col ">--}}
                                            {{--                                                <div class="xl:flex w-full gap-2">--}}
                                            {{--                                                    <label for="country_name"--}}
                                            {{--                                                           class="w-[10rem] text-zinc-500 tracking-wide py-2">Country</label>--}}
                                            {{--                                                    <div x-data="{isTyped: @entangle('countryTyped')}"--}}
                                            {{--                                                         @click.away="isTyped = false"--}}
                                            {{--                                                         class="w-full">--}}
                                            {{--                                                        <div class="relative">--}}
                                            {{--                                                            <input--}}
                                            {{--                                                                id="country_name"--}}
                                            {{--                                                                type="search"--}}
                                            {{--                                                                wire:model.live="itemList.{{0}}.country_name"--}}
                                            {{--                                                                autocomplete="off"--}}
                                            {{--                                                                placeholder="Choose.."--}}
                                            {{--                                                                @focus="isTyped = true"--}}
                                            {{--                                                                @keydown.escape.window="isTyped = false"--}}
                                            {{--                                                                @keydown.tab.window="isTyped = false"--}}
                                            {{--                                                                @keydown.enter.prevent="isTyped = false"--}}
                                            {{--                                                                wire:keydown.arrow-up="decrementCountry"--}}
                                            {{--                                                                wire:keydown.arrow-down="incrementCountry"--}}
                                            {{--                                                                wire:keydown.enter="enterCountry('{{0}}')"--}}
                                            {{--                                                                class="block w-full rounded-lg"--}}
                                            {{--                                                            />--}}

                                            {{--                                                            <!-- Country Dropdown -------------------------------------------------------------------->--}}
                                            {{--                                                            <div x-show="isTyped"--}}
                                            {{--                                                                 x-transition:leave="transition ease-in duration-100"--}}
                                            {{--                                                                 x-transition:leave-start="opacity-100"--}}
                                            {{--                                                                 x-transition:leave-end="opacity-0"--}}
                                            {{--                                                                 x-cloak--}}
                                            {{--                                                            >--}}
                                            {{--                                                                <div class="absolute z-20 w-full mt-2">--}}
                                            {{--                                                                    <div class="block py-1 shadow-md w-full--}}
                                            {{--                rounded-lg border-transparent flex-1 appearance-none border--}}
                                            {{--                                 bg-white text-gray-800 ring-1 ring-purple-600">--}}
                                            {{--                                                                        <ul class="overflow-y-scroll h-96">--}}
                                            {{--                                                                            @if($countryCollection)--}}
                                            {{--                                                                                @forelse ($countryCollection as $i => $country)--}}
                                            {{--                                                                                    <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8--}}
                                            {{--                                                        {{ $highlightCountry === $i ? 'bg-yellow-100' : '' }}"--}}
                                            {{--                                                                                        wire:click.prevent="setCountry('{{$country->vname}}','{{$country->id}}','{{0}}')"--}}
                                            {{--                                                                                        x-on:click="isTyped = false">--}}
                                            {{--                                                                                        {{ $country->vname }}--}}
                                            {{--                                                                                    </li>--}}
                                            {{--                                                                                @empty--}}
                                            {{--                                                                                    <button--}}
                                            {{--                                                                                        wire:click.prevent="countrySave('{{$itemList[0]['country_name']}}','{{0}}')"--}}
                                            {{--                                                                                        class="text-white bg-green-500 text-center w-full">--}}
                                            {{--                                                                                        create--}}
                                            {{--                                                                                    </button>--}}

                                            {{--                                                                                @endforelse--}}
                                            {{--                                                                            @endif--}}
                                            {{--                                                                        </ul>--}}
                                            {{--                                                                    </div>--}}
                                            {{--                                                                </div>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                        </div>

                                    </div>

                                    @foreach( $secondaryAddress as $index => $row )
                                        <div x-show="openTab === {{$row}}" class="p-2">

                                            <div class="flex flex-col gap-3">

                                                <x-input.floating wire:model="itemList.{{$row}}.address_1"
                                                                  label="Address"/>
                                                <x-input.floating wire:model="itemList.{{$row}}.address_2"
                                                                  label="Area-Road"/>

                                                <x-dropdown.wrapper label="City" type="cityTyped">
                                                    <div class="relative ">
                                                        <x-dropdown.input label="City" id="city_name"
                                                                          wire:model.live="itemList.{{$row}}.city_name"
                                                                          wire:keydown.arrow-up="decrementCity"
                                                                          wire:keydown.arrow-down="incrementCity"
                                                                          wire:keydown.enter="enterCity('{{$row}}')"/>
                                                        <x-dropdown.select>
                                                            @if($cityCollection)
                                                                @forelse ($cityCollection as $i => $city)
                                                                    <x-dropdown.option
                                                                        highlight="{{$highlightCity === $i  }}"
                                                                        wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}','{{$row}}')">
                                                                        {{ $city->vname }}
                                                                    </x-dropdown.option>
                                                                @empty
                                                                    <button
                                                                        wire:click.prevent="citySave('{{$itemList[$row]['city_name']}}','{{$row}}')"
                                                                        class="text-white bg-green-500 text-center w-full">
                                                                        create
                                                                    </button>
                                                                @endforelse
                                                            @endif
                                                        </x-dropdown.select>
                                                    </div>
                                                </x-dropdown.wrapper>

                                                {{--                                                <div class="flex flex-row ">--}}
                                                {{--                                                    <div class="xl:flex w-full gap-2">--}}
                                                {{--                                                        <label for="city_name"--}}
                                                {{--                                                               class="w-[10rem] text-zinc-500 tracking-wide py-2 ">City</label>--}}
                                                {{--                                                        <div x-data="{isTyped: @entangle('cityTyped')}"--}}
                                                {{--                                                             @click.away="isTyped = false"--}}
                                                {{--                                                             class="w-full">--}}
                                                {{--                                                            <div class="relative">--}}
                                                {{--                                                                <input--}}
                                                {{--                                                                    id="city_name"--}}
                                                {{--                                                                    type="search"--}}
                                                {{--                                                                    wire:model.live="itemList.{{$row}}.city_name"--}}
                                                {{--                                                                    autocomplete="off"--}}
                                                {{--                                                                    placeholder="Choose.."--}}
                                                {{--                                                                    @focus="isTyped = true"--}}
                                                {{--                                                                    @keydown.escape.window="isTyped = false"--}}
                                                {{--                                                                    @keydown.tab.window="isTyped = false"--}}
                                                {{--                                                                    @keydown.enter.prevent="isTyped = false"--}}
                                                {{--                                                                    wire:keydown.arrow-up="decrementCity"--}}
                                                {{--                                                                    wire:keydown.arrow-down="incrementCity"--}}
                                                {{--                                                                    wire:keydown.enter="enterCity('{{$row}}')"--}}
                                                {{--                                                                    class="block w-full rounded-lg "--}}
                                                {{--                                                                />--}}

                                                {{--                                                                <!-- City Dropdown -------------------------------------------------------------------->--}}

                                                {{--                                                                <div x-show="isTyped"--}}
                                                {{--                                                                     x-transition:leave="transition ease-in duration-100"--}}
                                                {{--                                                                     x-transition:leave-start="opacity-100"--}}
                                                {{--                                                                     x-transition:leave-end="opacity-0"--}}
                                                {{--                                                                     x-cloak--}}
                                                {{--                                                                >--}}
                                                {{--                                                                    <div class="absolute z-20 w-full mt-2">--}}
                                                {{--                                                                        <div class="block py-1 shadow-md w-full--}}
                                                {{--                rounded-lg border-transparent flex-1 appearance-none border--}}
                                                {{--                                 bg-white text-gray-800 ring-1 ring-purple-600">--}}
                                                {{--                                                                            <ul class="overflow-y-scroll h-96">--}}
                                                {{--                                                                                @if($cityCollection)--}}
                                                {{--                                                                                    @forelse ($cityCollection as $i => $city)--}}

                                                {{--                                                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8--}}
                                                {{--                                                        {{ $highlightCity === $i ? 'bg-yellow-100' : '' }}"--}}
                                                {{--                                                                                            wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}','{{$row}}')"--}}
                                                {{--                                                                                            x-on:click="isTyped = false">--}}
                                                {{--                                                                                            {{ $city->vname }}--}}
                                                {{--                                                                                        </li>--}}
                                                {{--                                                                                    @empty--}}
                                                {{--                                                                                        <button--}}
                                                {{--                                                                                            wire:click.prevent="citySave('{{$itemList[$row]['city_name']}}','{{$row}}')"--}}
                                                {{--                                                                                            class="text-white bg-green-500 text-center w-full">--}}
                                                {{--                                                                                            create--}}
                                                {{--                                                                                        </button>--}}
                                                {{--                                                                                    @endforelse--}}
                                                {{--                                                                                @endif--}}
                                                {{--                                                                            </ul>--}}
                                                {{--                                                                        </div>--}}
                                                {{--                                                                    </div>--}}
                                                {{--                                                                </div>--}}
                                                {{--                                                            </div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}

                                                <x-dropdown.wrapper label="State" type="stateTyped">
                                                    <div class="relative ">
                                                        <x-dropdown.input label="State" id="state_name"
                                                                          wire:model.live="itemList.{{$row}}.state_name"
                                                                          wire:keydown.arrow-up="decrementState"
                                                                          wire:keydown.arrow-down="incrementState"
                                                                          wire:keydown.enter="enterState('{{$row}}')"/>
                                                        <x-dropdown.select>
                                                            @if($stateCollection)
                                                                @forelse ($stateCollection as $i => $states)
                                                                    <x-dropdown.option
                                                                        highlight="{{$highlightState === $i  }}"
                                                                        wire:click.prevent="setState('{{$states->vname}}','{{$states->id}}','{{$row}}')">
                                                                        {{ $states->vname }}
                                                                    </x-dropdown.option>
                                                                @empty
                                                                    <button
                                                                        wire:click.prevent="stateSave('{{$itemList[$row]['state_name']}}','{{$row}}')"
                                                                        class="text-white bg-green-500 text-center w-full">
                                                                        create
                                                                    </button>
                                                                @endforelse
                                                            @endif
                                                        </x-dropdown.select>
                                                    </div>
                                                </x-dropdown.wrapper>

                                                {{--                                                <div class="flex flex-col ">--}}
                                                {{--                                                    <div class="xl:flex w-full gap-2">--}}
                                                {{--                                                        <label for="state_name"--}}
                                                {{--                                                               class="w-[10rem] text-zinc-500 tracking-wide py-2">State</label>--}}
                                                {{--                                                        <div x-data="{isTyped: @entangle('stateTyped')}"--}}
                                                {{--                                                             @click.away="isTyped = false"--}}
                                                {{--                                                             class="w-full">--}}
                                                {{--                                                            <div class="relative">--}}
                                                {{--                                                                <input--}}
                                                {{--                                                                    id="state_name"--}}
                                                {{--                                                                    type="search"--}}
                                                {{--                                                                    wire:model.live="itemList.{{$row}}.state_name"--}}
                                                {{--                                                                    autocomplete="off"--}}
                                                {{--                                                                    placeholder="Choose.."--}}
                                                {{--                                                                    @focus="isTyped = true"--}}
                                                {{--                                                                    @keydown.escape.window="isTyped = false"--}}
                                                {{--                                                                    @keydown.tab.window="isTyped = false"--}}
                                                {{--                                                                    @keydown.enter.prevent="isTyped = false"--}}
                                                {{--                                                                    wire:keydown.arrow-up="decrementState"--}}
                                                {{--                                                                    wire:keydown.arrow-down="incrementState"--}}
                                                {{--                                                                    wire:keydown.enter="enterState('{{$row}}')"--}}
                                                {{--                                                                    class="block w-full rounded-lg"--}}
                                                {{--                                                                />--}}

                                                {{--                                                                <!-- State Dropdown -------------------------------------------------------------------->--}}
                                                {{--                                                                <div x-show="isTyped"--}}
                                                {{--                                                                     x-transition:leave="transition ease-in duration-100"--}}
                                                {{--                                                                     x-transition:leave-start="opacity-100"--}}
                                                {{--                                                                     x-transition:leave-end="opacity-0"--}}
                                                {{--                                                                     x-cloak--}}
                                                {{--                                                                >--}}
                                                {{--                                                                    <div class="absolute z-20 w-full mt-2">--}}
                                                {{--                                                                        <div class="block py-1 shadow-md w-full--}}
                                                {{--                rounded-lg border-transparent flex-1 appearance-none border--}}
                                                {{--                                 bg-white text-gray-800 ring-1 ring-purple-600">--}}
                                                {{--                                                                            <ul class="overflow-y-scroll h-96">--}}
                                                {{--                                                                                @if($stateCollection)--}}
                                                {{--                                                                                    @forelse ($stateCollection as $i => $states)--}}

                                                {{--                                                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8--}}
                                                {{--                                                        {{ $highlightState === $i ? 'bg-yellow-100' : '' }}"--}}
                                                {{--                                                                                            wire:click.prevent="setState('{{$states->vname}}','{{$states->id}}','{{$row}}')"--}}
                                                {{--                                                                                            x-on:click="isTyped = false">--}}
                                                {{--                                                                                            {{ $states->vname }}--}}
                                                {{--                                                                                        </li>--}}

                                                {{--                                                                                    @empty--}}
                                                {{--                                                                                        <button--}}
                                                {{--                                                                                            wire:click.prevent="stateSave('{{$itemList[$row]['state_name']}}','{{$row}}')"--}}
                                                {{--                                                                                            class="text-white bg-green-500 text-center w-full">--}}
                                                {{--                                                                                            create--}}
                                                {{--                                                                                        </button>--}}
                                                {{--                                                                                    @endforelse--}}
                                                {{--                                                                                @endif--}}
                                                {{--                                                                            </ul>--}}
                                                {{--                                                                        </div>--}}
                                                {{--                                                                    </div>--}}
                                                {{--                                                                </div>--}}
                                                {{--                                                            </div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}

                                                <x-dropdown.wrapper label="Pincode" type="pincodeTyped">
                                                    <div class="relative ">
                                                        <x-dropdown.input label="Pincode" id="pincode_name"
                                                                          wire:model.live="itemList.{{$row}}.pincode_name"
                                                                          wire:keydown.arrow-up="decrementPincode"
                                                                          wire:keydown.arrow-down="incrementPincode"
                                                                          wire:keydown.enter="enterPincode('{{$row}}')"/>
                                                        <x-dropdown.select>
                                                            @if($pincodeCollection)
                                                                @forelse ($pincodeCollection as $i => $pincode)
                                                                    <x-dropdown.option
                                                                        highlight="{{$pincodeCollection === $i  }}"
                                                                        wire:click.prevent="setPincode('{{$pincode->vname}}','{{$pincode->id}}','{{$row}}')">
                                                                        {{ $pincode->vname }}
                                                                    </x-dropdown.option>
                                                                @empty
                                                                    <button
                                                                        wire:click.prevent="pincodeSave('{{$itemList[$row]['pincode_name']}}','{{$row}}')"
                                                                        class="text-white bg-green-500 text-center w-full">
                                                                        create
                                                                    </button>
                                                                @endforelse
                                                            @endif
                                                        </x-dropdown.select>
                                                    </div>
                                                </x-dropdown.wrapper>

                                                {{--                                                <div class="flex flex-col ">--}}
                                                {{--                                                    <div class="xl:flex w-full gap-2">--}}
                                                {{--                                                        <label for="pincode_name"--}}
                                                {{--                                                               class="w-[10rem] text-zinc-500 tracking-wide py-2">Pincode</label>--}}
                                                {{--                                                        <div x-data="{isTyped: @entangle('pincodeTyped')}"--}}
                                                {{--                                                             @click.away="isTyped = false"--}}
                                                {{--                                                             class="w-full">--}}
                                                {{--                                                            <div class="relative">--}}
                                                {{--                                                                <input--}}
                                                {{--                                                                    id="pincode_name"--}}
                                                {{--                                                                    type="search"--}}
                                                {{--                                                                    wire:model.live="itemList.{{$row}}.pincode_name"--}}
                                                {{--                                                                    autocomplete="off"--}}
                                                {{--                                                                    placeholder="Choose.."--}}
                                                {{--                                                                    @focus="isTyped = true"--}}
                                                {{--                                                                    @keydown.escape.window="isTyped = false"--}}
                                                {{--                                                                    @keydown.tab.window="isTyped = false"--}}
                                                {{--                                                                    @keydown.enter.prevent="isTyped = false"--}}
                                                {{--                                                                    wire:keydown.arrow-up="decrementPincode"--}}
                                                {{--                                                                    wire:keydown.arrow-down="incrementPincode"--}}
                                                {{--                                                                    wire:keydown.enter="enterPincode('{{$row}}')"--}}
                                                {{--                                                                    class="block w-full rounded-lg"--}}
                                                {{--                                                                />--}}

                                                {{--                                                                <!-- Pin-code Dropdown -------------------------------------------------------------------->--}}
                                                {{--                                                                <div x-show="isTyped"--}}
                                                {{--                                                                     x-transition:leave="transition ease-in duration-100"--}}
                                                {{--                                                                     x-transition:leave-start="opacity-100"--}}
                                                {{--                                                                     x-transition:leave-end="opacity-0"--}}
                                                {{--                                                                     x-cloak--}}
                                                {{--                                                                >--}}
                                                {{--                                                                    <div class="absolute z-20 w-full mt-2">--}}
                                                {{--                                                                        <div class="block py-1 shadow-md w-full--}}
                                                {{--                rounded-lg border-transparent flex-1 appearance-none border--}}
                                                {{--                                 bg-white text-gray-800 ring-1 ring-purple-600">--}}
                                                {{--                                                                            <ul class="overflow-y-scroll h-96">--}}
                                                {{--                                                                                @if($pincodeCollection)--}}
                                                {{--                                                                                    @forelse ($pincodeCollection as $i => $pincode)--}}
                                                {{--                                                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8--}}
                                                {{--                                                        {{ $highlightPincode === $i ? 'bg-yellow-100' : '' }}"--}}
                                                {{--                                                                                            wire:click.prevent="setPincode('{{$pincode->vname}}','{{$pincode->id}}','{{$row}}')"--}}
                                                {{--                                                                                            x-on:click="isTyped = false">--}}
                                                {{--                                                                                            {{ $pincode->vname }}--}}
                                                {{--                                                                                        </li>--}}
                                                {{--                                                                                    @empty--}}
                                                {{--                                                                                        <button--}}
                                                {{--                                                                                            wire:click.prevent="pincodeSave('{{$itemList[$row]['pincode_name']}}','{{$row}}')"--}}
                                                {{--                                                                                            class="text-white bg-green-500 text-center w-full">--}}
                                                {{--                                                                                            create--}}
                                                {{--                                                                                        </button>--}}

                                                {{--                                                                                    @endforelse--}}
                                                {{--                                                                                @endif--}}
                                                {{--                                                                            </ul>--}}
                                                {{--                                                                        </div>--}}
                                                {{--                                                                    </div>--}}
                                                {{--                                                                </div>--}}
                                                {{--                                                            </div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}


                                                <x-dropdown.wrapper label="Country" type="countryTyped">
                                                    <div class="relative ">

                                                        <x-dropdown.input label="Country" id="country_name"
                                                                          wire:model.live="itemList.{{$row}}.country_name"
                                                                          wire:keydown.arrow-up="decrementCountry"
                                                                          wire:keydown.arrow-down="incrementCountry"
                                                                          wire:keydown.enter="enterCountry('{{$row}}')"/>

                                                        <x-dropdown.select>
                                                            @if($countryCollection)

                                                                @forelse ($countryCollection as $i => $country)
                                                                    <x-dropdown.option
                                                                        highlight="{{$countryCollection === $i  }}"
                                                                        wire:click.prevent="setCountry('{{$country->vname}}','{{$country->id}}','{{$row}}')">
                                                                        {{ $country->vname }}
                                                                    </x-dropdown.option>

                                                                @empty

                                                                    <button
                                                                        wire:click.prevent="countrySave('{{$itemList[$row]['country_name']}}','{{$row}}')"
                                                                        class="text-white bg-green-500 text-center w-full">
                                                                        create
                                                                    </button>
                                                                @endforelse
                                                            @endif

                                                        </x-dropdown.select>
                                                    </div>
                                                </x-dropdown.wrapper>

                                                {{--                                                <div class="flex flex-col ">--}}
                                                {{--                                                    <div class="xl:flex w-full gap-2">--}}
                                                {{--                                                        <label for="country_name"--}}
                                                {{--                                                               class="w-[10rem] text-zinc-500 tracking-wide py-2">Country</label>--}}
                                                {{--                                                        <div x-data="{isTyped: @entangle('countryTyped')}"--}}
                                                {{--                                                             @click.away="isTyped = false"--}}
                                                {{--                                                             class="w-full">--}}
                                                {{--                                                            <div class="relative">--}}
                                                {{--                                                                <input--}}
                                                {{--                                                                    id="country_name"--}}
                                                {{--                                                                    type="search"--}}
                                                {{--                                                                    wire:model.live="itemList.{{$row}}.country_name"--}}
                                                {{--                                                                    autocomplete="off"--}}
                                                {{--                                                                    placeholder="Choose.."--}}
                                                {{--                                                                    @focus="isTyped = true"--}}
                                                {{--                                                                    @keydown.escape.window="isTyped = false"--}}
                                                {{--                                                                    @keydown.tab.window="isTyped = false"--}}
                                                {{--                                                                    @keydown.enter.prevent="isTyped = false"--}}
                                                {{--                                                                    wire:keydown.arrow-up="decrementCountry"--}}
                                                {{--                                                                    wire:keydown.arrow-down="incrementCountry"--}}
                                                {{--                                                                    wire:keydown.enter="enterCountry('{{$row}}')"--}}
                                                {{--                                                                    class="block w-full rounded-lg"--}}
                                                {{--                                                                />--}}

                                                {{--                                                                <!-- Country Dropdown -------------------------------------------------------------------->--}}
                                                {{--                                                                <div x-show="isTyped"--}}
                                                {{--                                                                     x-transition:leave="transition ease-in duration-100"--}}
                                                {{--                                                                     x-transition:leave-start="opacity-100"--}}
                                                {{--                                                                     x-transition:leave-end="opacity-0"--}}
                                                {{--                                                                     x-cloak--}}
                                                {{--                                                                >--}}
                                                {{--                                                                    <div class="absolute z-20 w-full mt-2">--}}
                                                {{--                                                                        <div class="block py-1 shadow-md w-full--}}
                                                {{--                rounded-lg border-transparent flex-1 appearance-none border--}}
                                                {{--                                 bg-white text-gray-800 ring-1 ring-purple-600">--}}
                                                {{--                                                                            <ul class="overflow-y-scroll h-96">--}}
                                                {{--                                                                                @if($countryCollection)--}}
                                                {{--                                                                                    @forelse ($countryCollection as $i => $country)--}}
                                                {{--                                                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8--}}
                                                {{--                                                        {{ $highlightCountry === $i ? 'bg-yellow-100' : '' }}"--}}
                                                {{--                                                                                            wire:click.prevent="setCountry('{{$country->vname}}','{{$country->id}}','{{$row}}')"--}}
                                                {{--                                                                                            x-on:click="isTyped = false">--}}
                                                {{--                                                                                            {{ $country->vname }}--}}
                                                {{--                                                                                        </li>--}}
                                                {{--                                                                                    @empty--}}
                                                {{--                                                                                        <button--}}
                                                {{--                                                                                            wire:click.prevent="countrySave('{{$itemList[$row]['country_name']}}','{{$row}}')"--}}
                                                {{--                                                                                            class="text-white bg-green-500 text-center w-full">--}}
                                                {{--                                                                                            create--}}
                                                {{--                                                                                        </button>--}}

                                                {{--                                                                                    @endforelse--}}
                                                {{--                                                                                @endif--}}
                                                {{--                                                                            </ul>--}}
                                                {{--                                                                        </div>--}}
                                                {{--                                                                    </div>--}}
                                                {{--                                                                </div>--}}
                                                {{--                                                            </div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}

                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                </x-tabs.content>

                <x-tabs.content>
                    <div class="flex flex-col gap-3">

                        <x-input.model-select wire:model="contact_type" :label="'Contact Type'">
                            <option class="text-gray-400"> choose ..</option>
                            <option value="Creditor">Creditor</option>
                            <option value="Debtor">Debtor</option>
                        </x-input.model-select>

                        <x-input.floating wire:model="msme_no" label="MSME No"/>
                        <x-input.floating wire:model="msme_type" label="MSME Type"/>
                        <x-input.floating wire:model="opening_balance" label="Opening Balance"/>

                        {{--                        <x-input.model-text wire:model="msme_no" :label="'MSME No'"/>--}}

                        {{--                        <x-input.model-text wire:model="msme_type" :label="'MSME Type'"/>--}}

                        {{--                        <x-input.model-text wire:model="opening_balance" :label="'Opening Balance'"/>--}}

                        <x-input.model-date wire:model="effective_from" :label="'Opening Date'"/>
                    </div>
                </x-tabs.content>

            </x-slot>
        </x-tabs.tab-panel>
    </x-forms.m-panel>

    <!-- Save Button area --------------------------------------------------------------------------------------------->
    <x-forms.m-panel-bottom-button active save back />
</div>

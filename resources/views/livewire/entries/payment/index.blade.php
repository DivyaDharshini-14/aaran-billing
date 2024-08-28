<div>
    <x-slot name="header">Payment</x-slot>

    <x-forms.m-panel>
        <x-forms.top-controls :show-filters="$showFilters"/>

        <x-table.caption :caption="'Payment'">
            {{$list->count()}}
        </x-table.caption>

        <x-table.form>
            <x-slot:table_header name="table_header" class="bg-green-100">

                <x-table.header-serial></x-table.header-serial>

                <x-table.header-text>Chq No</x-table.header-text>
                <x-table.header-text wire:click.prevent="sortBy('id')" sort-icon="{{$getListForm->sortAsc}}">Contact
                    Name
                </x-table.header-text>
                <x-table.header-text wire:click.prevent="sortBy('id')" sort-icon="{{$getListForm->sortAsc}}">Receipt
                    Type
                </x-table.header-text>

                <x-table.header-text wire:click.prevent="sortBy('id')" sort-icon="{{$getListForm->sortAsc}}">Mode
                </x-table.header-text>

                <x-table.header-text>Status</x-table.header-text>
                <x-table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)
                    <x-table.row>
                        <x-table.cell-text>{{$index+1}}</x-table.cell-text>
                        <x-table.cell-text>{{$row->vname}}</x-table.cell-text>
                        <x-table.cell-text>{{$row->contact->vname}}</x-table.cell-text>
                        <x-table.cell-text>
                            {{\Aaran\Entries\Models\Payment::common($row->receipttype_id)}}
                        </x-table.cell-text>
                        <x-table.cell-text>{{$row->mode}}</x-table.cell-text>
                        <x-table.cell-status active="{{$row->active_id}}"/>
                        <x-table.cell-action id="{{$row->id}}"/>
                    </x-table.row>
                @endforeach
            </x-slot:table_body>

        </x-table.form>

        <x-modal.delete/>

        <!-- Create  -------------------------------------------------------------------------------------------------->

        <x-forms.create :id="$common->vid">

            <div class="flex flex-col  gap-3">

                <div class="flex flex-row gap-3">
                    <div class="mb-[0.125rem] block min-h-[1.5rem] ps-[1.5rem]">Receipt
                        <input wire:model="mode"
                               class="relative float-left -ms-[1.5rem] me-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-secondary-500
                               before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0
                               before:shadow-checkbox before:shadow-transparent before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full
                               after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2
                               checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary
                               checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04]
                               hover:before:shadow-black/60 focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12]
                               focus:before:shadow-black/60 focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100
                               checked:focus:before:shadow-checkbox checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] rtl:float-right dark:border-neutral-400
                               dark:checked:border-primary"
                               type="radio"
                               name="flexRadioNoLabel" value="Receipt"
                               id="radioNoLabel01"/>
                    </div>

                    <!--Default checked radio without label-->
                    <div class="mb-[0.125rem] block min-h-[1.5rem] ps-[1.5rem]">Payment
                        <input wire:model="mode"
                               class="relative float-left -ms-[1.5rem] me-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-secondary-500
                               before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0
                               before:shadow-checkbox before:shadow-transparent before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full
                               after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2
                               checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary
                               checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04]
                               hover:before:shadow-black/60 focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12]
                               focus:before:shadow-black/60 focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100
                               checked:focus:before:shadow-checkbox checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] rtl:float-right dark:border-neutral-400
                               dark:checked:border-primary"
                               type="radio"
                               name="flexRadioNoLabel" value="Payment"
                               id="radioNoLabel02"
                               checked/>
                    </div>
                </div>


                <!-- Party Name --------------------------------------------------------------------------------------->
                <div class="xl:flex w-full gap-2">
                    <label for="contact_name" class="w-[10rem] text-zinc-500 tracking-wide py-2">Contact Name</label>
                    <div x-data="{isTyped: @entangle('contactTyped')}" @click.away="isTyped = false" class="w-full">
                        <div class="relative ">
                            <input
                                id="contact_name"
                                type="search"
                                wire:model.live="contact_name"
                                autocomplete="off"
                                placeholder="Contact Name.."
                                @focus="isTyped = true"
                                @keydown.escape.window="isTyped = false"
                                @keydown.tab.window="isTyped = false"
                                @keydown.enter.prevent="isTyped = false"
                                wire:keydown.arrow-up="decrementContact"
                                wire:keydown.arrow-down="incrementContact"
                                wire:keydown.enter="enterContact"
                                class="block w-full rounded-lg "
                            />
                            @error('contact_id')
                            <span class="text-red-500">{{'The Party Name is Required.'}}</span>
                            @enderror

                            <div x-show="isTyped"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 x-cloak
                            >
                                <div class="absolute z-20 w-full mt-2">
                                    <div class="block py-1 shadow-md w-full
                rounded-lg border-transparent flex-1 appearance-none border
                                 bg-white text-gray-800 ring-1 ring-purple-600">
                                        <ul class="overflow-y-scroll h-96">
                                            @if($contactCollection)
                                                @forelse ($contactCollection as $i => $contact)

                                                    <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-fit
                                                        {{ $highlightContact === $i ? 'bg-yellow-100' : '' }}"
                                                        wire:click.prevent="setContact('{{$contact->vname}}','{{$contact->id}}')"
                                                        x-on:click="isTyped = false">
                                                        {{ $contact->vname }}
                                                    </li>

                                                @empty
                                                    <a href="{{route('contacts.upsert',['0'])}}" role="button"
                                                       class="flex items-center justify-center bg-green-500 w-full h-8 text-white text-center">
                                                        Not found , Want to create new
                                                    </a>
                                                @endforelse
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-input.model-date wire:model="vdate" :label="'date'"/>

                <x-input.model-text wire:model="amount" :label="'Amount'"/>

                <!-- receipt type ------------------------------------------------------------------------------------->

                <div class="flex flex-row rounded-lg">
                    <div class="xl:flex w-full rounded-lg">
                        <label for="receipt_type_name" class="w-[10rem] text-zinc-500 tracking-wide">Type</label>
                        <div x-data="{isTyped: @entangle('receipt_typeTyped')}" @click.away="isTyped = false"
                             class="w-full relative ">
                            <div>
                                <input
                                    id="receipt_type_name"
                                    type="search"
                                    wire:model.live="receipt_type_name"
                                    autocomplete="off"
                                    placeholder="Type Name.."
                                    @focus="isTyped = true"
                                    @keydown.escape.window="isTyped = false"
                                    @keydown.tab.window="isTyped = false"
                                    @keydown.enter.prevent="isTyped = false"
                                    wire:keydown.arrow-up="decrementReceiptType"
                                    wire:keydown.arrow-down="incrementReceiptType"
                                    wire:keydown.enter="enterReceiptType"
                                    class="block w-full rounded-lg"
                                />

                                <div x-show="isTyped"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     x-cloak
                                >
                                    <div class="absolute z-20 w-full mt-2">
                                        <div class="block py-1 shadow-md w-full rounded-lg border-transparent flex-1 appearance-none border
                        bg-white text-gray-800 ring-1 ring-purple-600">
                                            <ul class="overflow-y-scroll h-96">
                                                @if($receipt_typeCollection)
                                                    @forelse ($receipt_typeCollection as $i => $receipt_type)
                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8
                                            {{ $highlightReceiptType === $i ? 'bg-yellow-100' : '' }}"
                                                            wire:click.prevent="setReceiptType('{{$receipt_type->vname}}','{{$receipt_type->id}}')"
                                                            x-on:click="isTyped = false">
                                                            {{ $receipt_type->vname }}
                                                        </li>
                                                    @empty
                                                        <button
                                                            wire:click.prevent="receiptTypeSave('{{$receipt_type_name}}')"
                                                            class="text-white bg-green-500 text-center w-full">
                                                            create
                                                        </button>
                                                    @endforelse
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- bank --------------------------------------------------------------------------------------------->
                <div class="flex flex-row ">
                    <div class="xl:flex w-full">
                        <label for="bank_name" class="w-[10rem] text-zinc-500 tracking-wide rounded-lg">Bank</label>
                        <div x-data="{isTyped: @entangle('bankTyped')}" @click.away="isTyped = false"
                             class="w-full relative ">
                            <div>
                                <input
                                    id="bank_name"
                                    type="search"
                                    wire:model.live="bank_name"
                                    autocomplete="off"
                                    placeholder="Bank Name.."
                                    @focus="isTyped = true"
                                    @keydown.escape.window="isTyped = false"
                                    @keydown.tab.window="isTyped = false"
                                    @keydown.enter.prevent="isTyped = false"
                                    wire:keydown.arrow-up="decrementBank"
                                    wire:keydown.arrow-down="incrementBank"
                                    wire:keydown.enter="enterBank"
                                    class="block w-full rounded-lg "
                                />

                                <div x-show="isTyped"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     x-cloak
                                >
                                    <div class="absolute z-20 w-full mt-2">
                                        <div class="block py-1 shadow-md w-full rounded-lg border-transparent flex-1 appearance-none border
                        bg-white text-gray-800 ring-1 ring-purple-600">
                                            <ul class="overflow-y-scroll h-96">
                                                @if($bankCollection)
                                                    @forelse ($bankCollection as $i => $bank)
                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8
                                            {{ $highlightBank === $i ? 'bg-yellow-100' : '' }}"
                                                            wire:click.prevent="setBank('{{$bank->vname}}','{{$bank->id}}')"
                                                            x-on:click="isTyped = false">
                                                            {{ $bank->vname }}
                                                        </li>
                                                    @empty
                                                        <button
                                                            wire:click.prevent="bankSave('{{$bank_name}}')"
                                                            class="text-white bg-green-500 text-center w-full">
                                                            create
                                                        </button>
                                                    @endforelse
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-input.model-text wire:model="common.vname" :label="'Chq No'"/>

                <x-input.model-date :label="'date'"/>



            </div>
        </x-forms.create>

    </x-forms.m-panel>
</div>
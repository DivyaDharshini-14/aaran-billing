<div>
    <x-slot name="header">Product</x-slot>

    <x-forms.m-panel>

        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-forms.top-controls :show-filters="$showFilters"/>

        <x-table.caption :caption="'Master'">
            {{$list->count()}}
        </x-table.caption>

        <!-- Table Header --------------------------------------------------------------------------------------------->
        <x-table.form>
            <x-slot:table_header name="table_header" class="bg-green-100">

                <x-table.header-serial width="20%"/>

                <x-table.header-text wire:click.prevent="sortBy('vname')" sortIcon="{{$getListForm->sortAsc}}">Product
                </x-table.header-text>

                <x-table.header-text wire:click.prevent="sortBy('product_type')" sortIcon="{{$getListForm->sortAsc}}">
                    Product Type
                </x-table.header-text>

                <x-table.header-text wire:click.prevent="sortBy('common_id')" sortIcon="{{$getListForm->sortAsc}}">HSN
                    Code
                </x-table.header-text>

                <x-table.header-text>Status</x-table.header-text>

                <x-table.header-action/>

            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)
                    <x-table.row>
                        <x-table.cell-text>{{$index+1}}</x-table.cell-text>
                        <x-table.cell-text>{{$row->vname}}</x-table.cell-text>
                        <x-table.cell-text>{{\Aaran\Master\Models\Product::common($row->producttype_id)}}</x-table.cell-text>
                        <x-table.cell-text>
                            {{\Aaran\Master\Models\Product::common($row->hsncode_id)}}
                        </x-table.cell-text>
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
                <x-input.model-text wire:model="common.vname" :label="'Name'"/>

                <div class="flex flex-row py-3 gap-3">
                    <div class="xl:flex w-full gap-2">
                        <label for="producttype_name" class="w-[10rem] text-zinc-500 tracking-wide py-2">Product Type</label>
                        <div x-data="{isTyped: @entangle('producttypeTyped')}" @click.away="isTyped = false" class="w-full relative">
                            <div>
                                <input
                                    id="producttype_name"
                                    type="search"
                                    wire:model.live="producttype_name"
                                    autocomplete="off"
                                    placeholder="Product Type Name.."
                                    @focus="isTyped = true"
                                    @keydown.escape.window="isTyped = false"
                                    @keydown.tab.window="isTyped = false"
                                    @keydown.enter.prevent="isTyped = false"
                                    wire:keydown.arrow-up="decrementProductType"
                                    wire:keydown.arrow-down="incrementProductType"
                                    wire:keydown.enter="enterProductType"
                                    class="block w-full purple-textbox"
                                />

                                <!-- Product Type Dropdown -->
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
                                                @if($producttypeCollection)
                                                    @forelse ($producttypeCollection as $i => $producttype)
                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8
                                            {{ $highlightProductType === $i ? 'bg-yellow-100' : '' }}"
                                                            wire:click.prevent="setProductType('{{$producttype->vname}}','{{$producttype->id}}')"
                                                            x-on:click="isTyped = false">
                                                            {{ $producttype->vname }}
                                                        </li>
                                                    @empty
                                                        <button
                                                            wire:click.prevent="productTypeSave('{{$producttype_name}}')"
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

                <div class="flex flex-row py-3 gap-3">
                    <div class="xl:flex w-full gap-2">
                        <label for="hsncode_name"
                               class="w-[10rem] text-zinc-500 tracking-wide py-2">HSN Code</label>
                        <div x-data="{isTyped: @entangle('hsncodeTyped')}" @click.away="isTyped = false"
                             class="w-full relative">
                            <div>
                                <input
                                    id="hsncode_name"
                                    type="search"
                                    wire:model.live="hsncode_name"
                                    autocomplete="off"
                                    placeholder="HSN Code Name.."
                                    @focus="isTyped = true"
                                    @keydown.escape.window="isTyped = false"
                                    @keydown.tab.window="isTyped = false"
                                    @keydown.enter.prevent="isTyped = false"
                                    wire:keydown.arrow-up="decrementHsncode"
                                    wire:keydown.arrow-down="incrementHsncode"
                                    wire:keydown.enter="enterHsncode"
                                    class="block w-full purple-textbox"
                                />

                                <!-- HSN Code Dropdown -->
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
                                                @if($hsncodeCollection)
                                                    @forelse ($hsncodeCollection as $i => $hsncode)
                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8
                                            {{ $highlightHsncode === $i ? 'bg-yellow-100' : '' }}"
                                                            wire:click.prevent="setHsncode('{{$hsncode->vname}}','{{$hsncode->id}}')"
                                                            x-on:click="isTyped = false">
                                                            {{ $hsncode->vname }}
                                                        </li>
                                                    @empty
                                                        <button
                                                            wire:click.prevent="hsncodeSave('{{$hsncode_name}}')"
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

                <div class="flex flex-row py-3 gap-3">
                    <div class="xl:flex w-full gap-2">
                        <label for="unit_name" class="w-[10rem] text-zinc-500 tracking-wide py-2">Unit</label>
                        <div x-data="{isTyped: @entangle('unitTyped')}" @click.away="isTyped = false" class="w-full relative">
                            <div>
                                <input
                                    id="unit_name"
                                    type="search"
                                    wire:model.live="unit_name"
                                    autocomplete="off"
                                    placeholder="Unit Name.."
                                    @focus="isTyped = true"
                                    @keydown.escape.window="isTyped = false"
                                    @keydown.tab.window="isTyped = false"
                                    @keydown.enter.prevent="isTyped = false"
                                    wire:keydown.arrow-up="decrementUnit"
                                    wire:keydown.arrow-down="incrementUnit"
                                    wire:keydown.enter="enterUnit"
                                    class="block w-full purple-textbox"
                                />

                                <!-- Unit Dropdown -->
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
                                                @if($unitCollection)
                                                    @forelse ($unitCollection as $i => $unit)
                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8
                                            {{ $highlightUnit === $i ? 'bg-yellow-100' : '' }}"
                                                            wire:click.prevent="setUnit('{{$unit->vname}}','{{$unit->id}}')"
                                                            x-on:click="isTyped = false">
                                                            {{ $unit->vname }}
                                                        </li>
                                                    @empty
                                                        <button
                                                            wire:click.prevent="unitSave('{{$unit_name}}')"
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

                <div class="flex flex-row py-3 gap-3">
                    <div class="xl:flex w-full gap-2">
                        <label for="gstpercent_name" class="w-[10rem] text-zinc-500 tracking-wide py-2">GST Percent</label>
                        <div x-data="{isTyped: @entangle('gstpercentTyped')}" @click.away="isTyped = false" class="w-full relative">
                            <div>
                                <input
                                    id="gstpercent_name"
                                    type="search"
                                    wire:model.live="gstpercent_name"
                                    autocomplete="off"
                                    placeholder="GST Percent Name.."
                                    @focus="isTyped = true"
                                    @keydown.escape.window="isTyped = false"
                                    @keydown.tab.window="isTyped = false"
                                    @keydown.enter.prevent="isTyped = false"
                                    wire:keydown.arrow-up="decrementGstPercent"
                                    wire:keydown.arrow-down="incrementGstPercent"
                                    wire:keydown.enter="enterGstPercent"
                                    class="block w-full purple-textbox"
                                />

                                <!-- GST Percent Dropdown -->
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
                                                @if($gstpercentCollection)
                                                    @forelse ($gstpercentCollection as $i => $gstpercent)
                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8
                                            {{ $highlightGstPercent === $i ? 'bg-yellow-100' : '' }}"
                                                            wire:click.prevent="setGstPercent('{{$gstpercent->vname}}','{{$gstpercent->id}}')"
                                                            x-on:click="isTyped = false">
                                                            {{ $gstpercent->vname }}
                                                        </li>
                                                    @empty
                                                        <button
                                                            wire:click.prevent="gstPercentSave('{{$gstpercent_name}}')"
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

                <x-input.model-text wire:model="quantity" :label="'Quantity'"/>
                <x-input.model-text wire:model="price" :label="'Price'"/>
            </div>

        </x-forms.create>

    </x-forms.m-panel>
</div>

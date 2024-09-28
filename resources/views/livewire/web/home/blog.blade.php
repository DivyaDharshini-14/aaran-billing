<div>

    <x-web.home-new.items.banner
        label="Blog"
        desc=" We Design and develop Outstanding Digital products and digital -
                first Brands"
        padding="sm:px-[95px]"
        padding_mob="px-[40px]"
    />

    <div class="flex sm:flex-row flex-col-reverse justify-center font-roboto tracking-wider my-16 gap-6 scroll-smooth">

        <div class="sm:w-6/12 w-auto flex-col flex gap-y-16 border-r border-gray-200 sm:pr-6 sm:px-0 px-2">
            @forelse($list as $row)

                <div class="group flex-col flex gap-y-4 border-b border-gray-300 pb-16 overflow-hidden">
                    <div class="text-2xl font-semibold animate__animated wow animate__backInLeft"
                         data-wow-duration="3s">{{$row->vname}}</div>

                    <img src="{{ \Illuminate\Support\Facades\Storage::url('/images/'.$row->image) }}" alt=""
                         class="h-[30rem] object-cover transition duration-700 ease-out group-hover:scale-105
                         animate__animated wow bounceInUp" data-wow-duration="3s">

                    <div
                        class="flex justify-between items-center gap-x-4 text-gray-600 text-sm animate__animated wow animate__backInLeft"
                        data-wow-duration="3s">
                        <div class="flex items-center gap-x-4">
                            <span class="inline-flex items-center gap-x-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="size-4 text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>{{ $row->created_at->diffForHumans() }}</span>
                            </span>

                            <span class="inline-flex items-center gap-x-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="size-4 text-gray-600">
                                <path fill-rule="evenodd"
                                      d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                      clip-rule="evenodd"/>
                                </svg>
                                <span class="uppercase mt-1">POST BY : {{$row->user->name}}</span>
                            </span>

                            <span class="inline-flex items-center gap-x-1 ">
                                <span class="uppercase mt-1">| {{$row->visibility==0?'Private':'Public'}}</span>
                            </span>
                        </div>

                        <div class="flex items-center gap-x-4 animate__animated wow animate__backInRight"
                             data-wow-duration="3s">
                            <span class="text-blue-600">
                                #{{ \Aaran\Blog\Models\Post::type($row->blogcategory_id) ?: 'posts'}}
                            </span>
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-md border border-blue-600">
                                {{ \Aaran\Blog\Models\Post::tagName($row->blogtag_id) ?: 'posts'}}
                            </span>
                        </div>
                    </div>

                    <div class="text-gray-600 text-sm animate__animated wow bounceInUp"
                         data-wow-duration="3s">{{$row->body}}
                    </div>
                </div>
            @empty
                <x-image.empty_post/>
            @endforelse

            <div class="pt-5">{{ $list->links() }}</div>
        </div>

        <div class="sm:w-3/12 w-auto scroll-smooth sm:px-0 px-2">

            <div class="relative w-full">
                <label for="">
                <span class="w-full">

                <input type="text" placeholder="Search" wire:model.live="getListForm.searches"
                       wire:keydown.escape="$set('getListForm.searches', '')"
                       class="w-full h-14 border-0 focus:ring-0  bg-[#F9FAFB] text-gray-600 placeholder-[#3F5AF3]">
                </span>

                    <span class="absolute top-0 right-0 w-14 h-14 bg-[#F31A49] inline-flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="size-6 text-white">
                      <path fill-rule="evenodd"
                            d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                            clip-rule="evenodd"/>
                    </svg>
                </span>
                </label>

                <div class="my-5">
                    <x-button.new-x wire:click="create"/>
                </div>
            </div>

            <!-- Form create  ----------------------------------------------------------------------------------------->

            <x-forms.create :id="$common->vid" :max-width="'xl'">
                <div class="flex flex-col gap-4">

                    {{--            <x-input.model-text wire:model="common.vname" :label="'Name'"/>--}}

                    <div class="inline-flex gap-3">
                        <input type="checkbox" wire:model="visibility">
                        <label for="">Public</label>
                    </div>

                    <x-input.floating wire:model="common.vname" label="Name"/>
                    @error('common.vname')
                    <div class="text-xs text-red-500">
                        {{$message}}
                    </div>
                    @enderror

                    <x-input.textarea wire:model="body" label="Description"/>
                    @error('body')
                    <div class="text-xs text-red-500">
                        {{$message}}
                    </div>
                    @enderror

                    <x-dropdown.wrapper label="Blog Category" type="blogcategoryTyped">
                        <div class="relative ">
                            <x-dropdown.input label="Blog Category" id="blogcategory_name"
                                              wire:model.live="blogcategory_name"
                                              wire:keydown.arrow-up="decrementBlogcategory"
                                              wire:keydown.arrow-down="incrementBlogcategory"
                                              wire:keydown.enter="enterBlogcategory"/>
                            <x-dropdown.select>
                                @if($blogcategoryCollection)
                                    @forelse ($blogcategoryCollection as $i => $blogcategory)
                                        <x-dropdown.option highlight="{{$highlightBlogCategory === $i  }}"
                                                           wire:click.prevent="setBlogcategory('{{$blogcategory->vname}}','{{$blogcategory->id}}')">
                                            {{ $blogcategory->vname }}
                                        </x-dropdown.option>
                                    @empty
                                        <button
                                            wire:click.prevent="blogcategorySave('{{$blogcategory_name}}')"
                                            class="text-white bg-green-500 text-center w-full">
                                            create
                                        </button>
                                    @endforelse
                                @endif
                            </x-dropdown.select>
                        </div>
                    </x-dropdown.wrapper>

                    <x-dropdown.wrapper label="Blog Tag" type="blogtagTyped">
                        <div class="relative ">
                            <x-dropdown.input label="Blog Tag" id="blogtag_name"
                                              wire:model.live="blogtag_name"
                                              wire:keydown.arrow-up="decrementBlogtag"
                                              wire:keydown.arrow-down="incrementBlogtag"
                                              wire:keydown.enter="enterBlogtag"/>
                            <x-dropdown.select>
                                @if($blogtagCollection)
                                    @forelse ($blogtagCollection as $i => $blogtag)
                                        <x-dropdown.option highlight="{{$highlightBlogCategory === $i  }}"
                                                           wire:click.prevent="setBlogTag('{{$blogtag->vname}}','{{$blogtag->id}}')">
                                            {{ $blogtag->vname }}
                                        </x-dropdown.option>
                                    @empty
                                        <button
                                            wire:click.prevent="blogtagSave('{{$blogtag_name}}')"
                                            class=" bg-blue-100 text-blue-600 text-center hover:font-bold w-full">
                                            create
                                        </button>
                                    @endforelse
                                @endif
                            </x-dropdown.select>
                        </div>
                    </x-dropdown.wrapper>

                    <!-- Image  ----------------------------------------------------------------------------------------------->

                    <div class="flex flex-col py-2">
                        <label for="bg_image"
                               class="w-full text-zinc-500 tracking-wide pb-4 px-2">Image</label>
                        <div class="flex flex-wrap gap-2">
                            <div class="flex-shrink-0">
                                <div>
                                    @if($image)
                                        <div
                                            class=" flex-shrink-0 border-2 border-dashed border-gray-300 p-1 rounded-lg overflow-hidden">
                                            <img
                                                class="w-[156px] h-[89px] rounded-lg hover:brightness-110 hover:scale-105 duration-300 transition-all ease-out"
                                                src="{{ $image->temporaryUrl() }}"
                                                alt="{{$image?:''}}"/>
                                        </div>
                                    @endif

                                    @if(!$image && isset($image))
                                        <img class="h-24 w-full"
                                             src="{{URL(\Illuminate\Support\Facades\Storage::url('images/'.$old_image))}}"
                                             alt="">
                                    @else
                                        <x-icons.icon :icon="'logo'" class="w-auto h-auto block "/>
                                    @endif
                                </div>
                            </div>
                            <div class="relative">
                                <div>
                                    <label for="bg_image"
                                           class="text-gray-500 font-semibold text-base rounded flex flex-col items-center
                                   justify-center cursor-pointer border-2 border-gray-300 border-dashed p-2
                                   mx-auto font-[sans-serif]">
                                        <x-icons.icon icon="cloud-upload" class="w-8 h-auto block text-gray-400"/>
                                        Upload Photo
                                        <input type="file" id='bg_image' wire:model="image" class="hidden"/>
                                        <p class="text-xs font-light text-gray-400 mt-2">PNG and JPG are
                                            Allowed.</p>
                                    </label>
                                </div>

                                <div wire:loading wire:target="image" class="z-10 absolute top-6 left-12">
                                    <div class="w-14 h-14 rounded-full animate-spin
                                                        border-y-4 border-dashed border-green-500 border-t-transparent"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </x-forms.create>

            <div class="text-2xl font-semibold my-6 animate__animated wow bounceInRight" data-wow-duration="3s">Top
                Posts
            </div>

            <div class="flex-col flex gap-y-6">
                <div class="bg-white flex-col flex gap-y-4 group ">
                    @foreach($topPost as $row)
                        <div
                            class="w-full h-auto flex gap-x-2 hover:bg-slate-100 animate__animated wow animate__backInRight"
                            data-wow-duration="3s">
                            <div class="w-2/6 ">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url('/images/'.$row->image) }}"
                                     class="w-full h-20">
                            </div>
                            <div class="w-4/6 flex-col flex py-1 ">
                                <div class="h-1/4 inline-flex items-center gap-x-2">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                             class="size-3">
                                        <path fill-rule="evenodd"
                                              d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                              clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <span class="text-xs text-gray-600">By {{$row->user->name}}</span>
                                </div>
                                <div class="3/4 flex-col flex justify-start items-start ">
                                    <div
                                        class="text-md font-semibold">{{\Illuminate\Support\Str::words($row->vname, 5)}}</div>
                                    <div class="text-xs">{{\Illuminate\Support\Str::words($row->body, 9)}}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Blog Category ------------------------------------------------------------------------------------>

            <div class="text-2xl font-semibold mt-9 scroll-smooth animate__animated wow bounceInRight"
                 data-wow-duration="3s">Category
            </div>

            <div class="flex-col flex justify-between w-full overflow-y-auto h-72">

                @foreach($BlogCategories as $blogcategory)

                    <button wire:click="getCategory_id({{$blogcategory->id}})"
                            class="h-12 w-3/4 inline-flex items-center gap-x-4 py-2 my-3 bg-red-50 text-red-600 px-4 group hover:bg-red-600 rounded-md mr-2 transition-all ease-linear duration-300
                            animate__animated wow animate__backInRight" data-wow-duration="3s">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-4 h-4 text-red-600 group-hover:text-white">
                            <path fill-rule="evenodd"
                                  d="M1.5 7.125c0-1.036.84-1.875 1.875-1.875h6c1.036 0 1.875.84 1.875 1.875v3.75c0 1.036-.84 1.875-1.875 1.875h-6A1.875 1.875 0 0 1 1.5 10.875v-3.75Zm12 1.5c0-1.036.84-1.875 1.875-1.875h5.25c1.035 0 1.875.84 1.875 1.875v8.25c0 1.035-.84 1.875-1.875 1.875h-5.25a1.875 1.875 0 0 1-1.875-1.875v-8.25ZM3 16.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875v2.25c0 1.035-.84 1.875-1.875 1.875h-5.25A1.875 1.875 0 0 1 3 18.375v-2.25Z"
                                  clip-rule="evenodd"/>
                        </svg>

                        <span class="group-hover:text-white">{{$blogcategory->vname}}</span>
                    </button>
                @endforeach

            </div>


            <!-- Tag Filter --------------------------------------------------------------------------------------->

            <div class="grid grid-cols-3 gap-2 my-8 scroll-smooth">
                @if($tagfilter)
                    @foreach($tagfilter as $index => $i)

                        <span
                            class="group max-w-max inline-flex items-center gap-x-2 px-2 py-1 bg-[#3F5AF3] text-white rounded-md">
                            {{\Aaran\Blog\Models\BlogTag::find($i)->vname}}
                            <button wire:click="removeFilter({{$index}})"
                                    class="inline-flex justify-center items-center">
                                <x-icons.icon :icon="'x-mark'" class="group-hover:scale-125 w-4 h-5 font-bold"/>
                            </button>
                        </span>
                    @endforeach
                    <button wire:click="clearFilter()"
                            class="max-w-max px-2 py-1 border border-gray-200 rounded-md text-xs hover:bg-blue-100">
                        Clear All
                    </button>
                @endif
            </div>

            <!-- Blog Tag ----------------------------------------------------------------------------------------->

            <div class="text-2xl font-semibold my-6">Tags</div>

            <div class="flex-col flex gap-2 text-sm h-64 overflow-y-auto scroll-smooth">
                @if($tags)
                    @foreach($tags as $tag)
                        <button wire:click="getFilter({{$tag->id}})"
                                class="group px-4 py-2 border border-gray-200 text-center hover:bg-[#3F5AF3] hover:text-white duration-300 transition-all ease-linear inline-flex items-center gap-x-3 rounded-md mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-4 h-4 text-blue-600 group-hover:text-white">
                                <path fill-rule="evenodd"
                                      d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span class="text-xs text-blue-600 group-hover:text-white">{{$tag->vname}} </span>
                        </button>
                    @endforeach
                @endif
            </div>


        </div>
    </div>

    <x-web.home-new.footer/>
</div>

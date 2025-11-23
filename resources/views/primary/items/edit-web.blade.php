@php
    $layout = session('layout');

    $space_id = session('space_id') ?? null;
    if(is_null($space_id)){
        abort(403);
    }



    $user = auth()->user();
    $space_role = session('space_role') ?? null;

    
    $allow_cost = $user->can('space.supplies.cost', 'web') || $space_role == 'owner';



    $list_images = $data->images ?? [];
@endphp


<x-dynamic-component :component="'layouts.' . $layout">
    <div class="py-12">
        <div class=" sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h3 class="text-2xl dark:text-white font-bold">Edit Items: {{ $data->name }}</h3>
                    <div class="my-6 flex-grow border-t border-gray-300 dark:border-gray-700"></div>

                    <form action="{{ route('items.update', $data->id) }}" 
                        method="POST" 
                        enctype="multipart/form-data"
                        onsubmit="return validateForm()">
                        @csrf
                        @method('PUT')


                        @include('primary.items.partials.dataform', ['form' => ['id' => 'Edit Item', 'mode' => 'edit']])

                        <div class="my-6 flex-grow border-t border-gray-300 dark:border-gray-700"></div>



                        <!-- images  -->
                        <div class="grid grid-cols-2 sm:grid-cols-2 gap-6 w-full mb-4">
                            <div class="form-group">
                                <x-div.box-show title="Gambar Terkait">
                                    <x-input-label for="images">Upload File Terkait (max 2 MB)</x-input-label>
                                    <input type="file" name="images[]" class="form-control" id="images" multiple >

                                    <!-- List File Lama -->
                                    <ul id="images-list" class="mt-2">
                                        @if(!empty($data->images))
                                            @foreach($data->images as $index => $image)
                                                <li data-old="{{ $index }}" class="flex items-center gap-2">
                                                    <a href="{{ asset($image['path']) }}" target="_blank">{{ $image['name'] }}</a>
                                                    <button type="button" class="remove-old-image text-red-500">Hapus</button>
                                                    <input type="hidden" name="old_images[{{ $index }}][name]" value="{{ $image['name'] ?? '' }}">
                                                    <input type="hidden" name="old_images[{{ $index }}][path]" value="{{ $image['path'] ?? '' }}">
                                                    <input type="hidden" name="old_images[{{ $index }}][size]" value="{{ $image['size'] ?? 0 }}">
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </x-div.box-show>

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    // Hapus image lama
                                    document.addEventListener("click", function(e) {
                                        if (e.target.classList.contains("remove-old-image")) {
                                            e.target.closest("li").remove();
                                        }
                                    });

                                    // Hapus image baru
                                    document.getElementById("images").addEventListener("change", function(e) {
                                        const list = document.getElementById("images-list");
                                        list.querySelectorAll(".new-image").forEach(el => el.remove());

                                        Array.from(e.target.images).forEach((image, i) => {
                                            let li = document.createElement("li");
                                            li.classList.add("new-image","flex","items-center","gap-2");
                                            li.textContent = image.name;

                                            let btn = document.createElement("button");
                                            btn.type = "button";
                                            btn.className = "remove-new-image text-red-500";
                                            btn.textContent = "Hapus";

                                            btn.addEventListener("click", () => {
                                                let dt = new DataTransfer();
                                                Array.from(e.target.images).forEach((f, idx) => {
                                                    if (idx !== i) dt.items.add(f);
                                                });
                                                e.target.images = dt.images;
                                                li.remove();
                                            });

                                            li.appendChild(btn);
                                            list.appendChild(li);
                                        });
                                    });
                                });
                            </script>
                            </div>

                            <x-div.box-show title="File Terkait">
                            @if(!empty($list_images))
                                <table class="min-w-full border border-gray-300 text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border px-2 py-1 text-left">#</th>
                                            <th class="border px-2 py-1 text-left">TX Number</th>
                                            <th class="border px-2 py-1 text-left">Nama File</th>
                                            <th class="border px-2 py-1 text-left">Ukuran</th>
                                            <th class="border px-2 py-1 text-left">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list_images as $index => $image)
                                            <tr>
                                                <td class="border px-2 py-1">{{ $index + 1 }}</td>
                                                <td>Number</td>
                                                <td class="border px-2 py-1">
                                                    <a href="{{ asset($image['path']) }}" target="_blank" class="text-blue-600 hover:underline">
                                                        {{ $image['name'] }}
                                                    </a>
                                                </td>
                                                <td class="border px-2 py-1">
                                                    @if(!empty($image['size']))
                                                        {{ number_format($image['size'] / 1024, 2) }} KB
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="border px-2 py-1">
                                                    <a href="{{ asset($image['path']) }}" download class="text-green-600 hover:underline">
                                                        Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-500">Tidak ada image terkait.</p>
                            @endif
                        </x-div.box-show>
                        </div>
                        <div class="my-6 flex-grow border-t border-gray-300 dark:border-gray-700"></div>



                        <div class="m-4 flex justify-end space-x-4">
                            <a href="{{ route('items.show', $data->id) }}">
                                <x-secondary-button type="button">Cancel</x-secondary-button>
                            </a>
                            <x-primary-button>Update Data</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>


<!-- files upload list -->
<script>
    $(document).ready(function() {
        let data = {!! json_encode($data) !!};

        console.log(data);

        // document.getElementById('edit_id').value = data.id;

        document.getElementById('edit_code').value = data.code;
        document.getElementById('edit_sku').value = data.sku;
        document.getElementById('edit_name').value = data.name;

        $('#edit_price').val(data.price);

        let allow_cost = "{{ $allow_cost }}" ? true : false;
        if(allow_cost) 
            $('#edit_cost').val(data.cost);


        $('#edit_weight').val(data.weight);

        document.getElementById('edit_status').value = data.status;


        document.getElementById('edit_tags').value = JSON.stringify(data.tags ?? []);
        document.getElementById('edit_links').value = JSON.stringify(data.links ?? []);

        document.getElementById('edit_notes').value = data.notes;
        document.getElementById('edit_description').value = data.description;
    });
</script>
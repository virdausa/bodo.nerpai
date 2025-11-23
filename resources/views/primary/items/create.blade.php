<x-crud.modal-create title="Create Item" trigger="Create Item">
    <form action="{{ route('items.store') }}" method="POST" class="mt-4" id="createDataForm">
        @csrf
        @include('primary.items.partials.dataform', ['form' => ['id' => 'Create Item', 'mode' => 'create']])

        <!-- Actions -->
        <div class="flex justify-end space-x-4 mt-4">
            <x-primary-button type="submit">{{ $form['id'] ?? 'Save' }}</x-primary-button>
            <button type="button" @click="isOpen = false"
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700">Cancel</button>
        </div>
    </form>
</x-crud.modal-create>